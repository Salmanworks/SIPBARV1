<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Layanan import CSV berbasis native PHP (fgetcsv).
 * Tanpa dependency eksternal, 100% kompatibel dengan semua versi PHP/Laravel
 * dan bisa dibuka/export via Excel, Google Sheet, LibreOffice sebagai CSV.
 *
 * Format CSV yang diharapkan:
 * - Baris pertama = header nama kolom (case-insensitive, bisa ada spasi)
 * - Delimiter otomatis detect: koma, titik koma, tab
 * - Encoding: UTF-8 (dengan BOM support via strip_bom())
 */
class CsvImporterService
{
    /**
     * Normalisasi nama kolom header: strip BOM, lowercase, trim, ganti spasi/jenis karakter jadi underscore.
     */
    public static function normalizeHeader(string $col): string
    {
        $col = self::stripBom($col);
        $col = Str::lower(trim($col));
        $col = preg_replace('/[\s\-]+/', '_', $col) ?? $col;

        return $col;
    }

    public static function stripBom(string $str): string
    {
        $bom = "\xEF\xBB\xBF";
        if (str_starts_with($str, $bom)) {
            return substr($str, 3);
        }

        return $str;
    }

    /**
     * Baca file CSV menjadi array asosiatif. Auto-detect delimiter.
     *
     * @return array{headers: list<string>, rows: list<array<string,string>>}
     */
    public static function readCsv(UploadedFile $file, int $maxRows = 5000): array
    {
        $handle = @fopen($file->getRealPath(), 'r');
        if ($handle === false) {
            throw ValidationException::withMessages([
                'file' => ['Gagal membaca file CSV yang diupload.'],
            ]);
        }

        $delimiter = self::detectDelimiter($handle);

        $row = fgetcsv($handle, 0, $delimiter);
        if ($row === false || count(array_filter($row, fn ($c) => trim((string) $c) !== '')) === 0) {
            fclose($handle);
            throw ValidationException::withMessages([
                'file' => ['File CSV kosong atau format tidak valid (baris header tidak ditemukan).'],
            ]);
        }

        $headers = array_map(fn ($h) => self::normalizeHeader((string) $h), $row);

        $rows = [];
        $count = 0;
        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            $count++;
            if ($count > $maxRows) {
                fclose($handle);
                throw ValidationException::withMessages([
                    'file' => ["Maksimal {$maxRows} baris data per sekali import (tidak termasuk header)."],
                ]);
            }

            // Skip baris kosong
            if (count(array_filter($data, fn ($c) => trim((string) $c) !== '')) === 0) {
                continue;
            }

            $assoc = [];
            foreach ($headers as $idx => $header) {
                $assoc[$header] = isset($data[$idx]) ? self::stripBom(trim((string) $data[$idx])) : '';
            }
            $rows[] = $assoc;
        }

        fclose($handle);

        return [
            'headers' => $headers,
            'rows' => $rows,
        ];
    }

    /**
     * Coba baca beberapa baris pertama untuk detect delimiter:
     * koma (,) = standard, titik koma (;) = Excel Indonesia default, tab (\t) = TSV.
     */
    protected static function detectDelimiter($handle): string
    {
        rewind($handle);
        $sample = '';
        for ($i = 0; $i < 3; $i++) {
            $line = fgets($handle);
            if ($line === false) {
                break;
            }
            $sample .= $line;
        }
        rewind($handle);

        if ($sample === '') {
            return ',';
        }

        $counts = [
            ',' => substr_count($sample, ','),
            ';' => substr_count($sample, ';'),
            "\t" => substr_count($sample, "\t"),
        ];
        arsort($counts);

        $winner = (string) array_key_first($counts);

        return $counts[$winner] > 0 ? $winner : ',';
    }

    /**
     * Cari nilai dari array asosiatif berdasarkan list alias kolom (case-insensitive).
     *
     * @param  array<string,string>  $row
     * @param  list<string>  $aliases
     */
    public static function pick(array $row, array $aliases): ?string
    {
        foreach ($aliases as $alias) {
            $alias = self::normalizeHeader($alias);
            foreach ($row as $key => $val) {
                if (self::normalizeHeader($key) === $alias && $val !== '') {
                    return $val;
                }
            }
        }

        return null;
    }
}
