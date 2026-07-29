<?php

namespace App\Services;

use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Service untuk Generate & Verify QR Code Peminjaman SIPBAR.
 *
 * Sesuai BRIEF C5: QR berisi:
 *  - Transaction ID (peminjaman.id)
 *  - Token (random + signed HMAC-SHA256 pakai app.key)
 *  - Status saat generate
 *  - Tanggal generate
 *  - Signature (verifikasi anti-palsu)
 *
 * Format payload (signed JSON → base64 encoded):
 *   {
 *     "pid": 123,
 *     "tok": "random40char",
 *     "st":  "disetujui",
 *     "d":   "2026-07-28",
 *     "sig": "hmac_sha256(app.key, pid|tok|st|d)"
 *   }
 */
class QRCodeService
{
    private const HASH_ALGO = 'sha256';

    /**
     * Generate QR Code untuk data string apapun, hasilnya file SVG
     * (TANPA BUTUH PHP EXT-IMAGICK, work di semua XAMPP).
     */
    public function generate(string $data, string $filename = null): string
    {
        $filename = $filename ?? 'qr-' . Str::uuid() . '.svg';
        $path     = 'qrcodes/' . $filename;

        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );

        $writer   = new Writer($renderer);
        $contents = $writer->writeString($data);

        Storage::disk('public')->put($path, $contents);

        return $path;
    }

    /**
     * Generate **secure signed payload** untuk QR Code Peminjaman
     * (sesuai spesifikasi Brief: PID, Token, Status, Tanggal + Signature).
     *
     * @return array{pid:int, tok:string, st:string, d:string, sig:string}
     */
    public function generateSecurePayload(\App\Models\Peminjaman $peminjaman): array
    {
        $payload = [
            'pid' => $peminjaman->id,
            'tok' => Str::random(40),
            'st'  => $peminjaman->status instanceof \BackedEnum
                ? $peminjaman->status->value
                : (string)$peminjaman->status,
            'd'   => now()->toDateString(),
        ];

        $payload['sig'] = $this->computeSignature($payload);

        return $payload;
    }

    /**
     * Encode payload array secure menjadi string siap disisipkan ke QR.
     */
    public function encodePayloadForQr(array $payload): string
    {
        return 'sipbar://qr/' . base64_encode(json_encode($payload, JSON_UNESCAPED_SLASHES));
    }

    /**
     * Decode string dari QR scan, lalu VERIFY signature-nya.
     * Return:  array payload jika VALID, null jika TIDAK VALID / palsu.
     *
     * @return array{pid:int, tok:string, st:string, d:string, sig:string}|null
     */
    public function decodeAndVerify(string $qrRaw): ?array
    {
        $raw = trim($qrRaw);

        if (Str::startsWith($raw, 'sipbar://qr/')) {
            $b64 = Str::after($raw, 'sipbar://qr/');
            $json = base64_decode($b64, true);
            if ($json === false) {
                return null;
            }
            $payload = json_decode($json, true);
        } else {
            // Fallback: jika raw adalah JSON langsung
            $payload = json_decode($raw, true);
        }

        if (! is_array($payload) || ! isset($payload['pid'], $payload['tok'], $payload['st'], $payload['d'], $payload['sig'])) {
            return null;
        }

        $expected = $this->computeSignature($payload);
        if (! hash_equals($expected, (string)$payload['sig'])) {
            return null; // signature salah → QR Palsu / dimanipulasi
        }

        return $payload;
    }

    /**
     * Compute HMAC-SHA256 signature pakai APP_KEY.
     */
    private function computeSignature(array $payload): string
    {
        $base = $payload['pid'] . '|' . $payload['tok'] . '|' . $payload['st'] . '|' . $payload['d'];

        return hash_hmac(self::HASH_ALGO, $base, config('app.key'));
    }

    /**
     * Generate QR untuk peminjaman (LEGACY method, agar tidak breaking).
     */
    public function generateForPeminjaman(int $peminjamanId): string
    {
        $data = route('peminjaman.show', $peminjamanId);
        return $this->generate($data, "peminjaman-{$peminjamanId}.svg");
    }

    public function delete(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Generate URL asset public untuk file QR.
     */
    public function url(string $path): string
    {
        return Storage::disk('public')->url($path);
    }
}
