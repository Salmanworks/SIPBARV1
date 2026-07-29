<?php

namespace App\Services;

use App\Enums\DendaStatus;
use App\Enums\KondisiBarang;
use App\Enums\PeminjamanStatus;
use App\Models\Barang;
use App\Models\Denda;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Single source of truth untuk semua operasi mutasi data Peminjaman.
 *
 * 🔴 ALUR STOK (sesuai bisnis rules SIPBAR — anti mismatch):
 *   [Diajukan]    →  Stok TIDAK DIUBAH       (hanya booking conceptual)
 *   [Ditolak]     →  Stok TIDAK DIUBAH       (karena belum dikurangi)
 *   [Disetujui]   →  Stok TIDIDAK BERUBAH (menunggu Guru serahkan)
 Verified di logika
 *   Verifikasi Keluar = STATUS "DIPINJAM":
 *   ✅
 */
class PeminjamanService
{
    public function __construct(
        private QRCodeService $qrCodeService
    ) {}

    /**
     * Approve pengajuan peminjaman (Diajukan → Disetujui).
     * - Validasi stok cukup
     * - Generate QR Code transaksi
     */
    public function approve(Peminjaman $peminjaman, int $approverId, ?string $catatanAdmin = null): Peminjaman
    {
        if ($peminjaman->status !== PeminjamanStatus::Diajukan) {
            throw ValidationException::withMessages(['status' => 'Peminjaman tidak dapat disetujui pada status ini.']);
        }

        // ✅ Validasi ketersediaan stok (check real-time)
        $this->validateStock($peminjaman);

        return DB::transaction(function () use ($peminjaman, $approverId, $catatanAdmin) {
            $peminjaman->update([
                'status'         => PeminjamanStatus::Disetujui,
                'disetujui_oleh' => $approverId,
                'catatan_admin'  => $catatanAdmin,
            ]);

            // 🔐 Generate secure QR Code after approved (tokenized, bukan raw ID)
            $qrPayload = $this->qrCodeService->generateSecurePayload($peminjaman);
            $qrPath = $this->qrCodeService->generate(
                $this->qrCodeService->encodePayloadForQr($qrPayload),
                "peminjaman-{$peminjaman->id}.svg"
            );
            $peminjaman->update(['qr_code' => $qrPath, 'qr_token' => $qrPayload['tok']]);

            return $peminjaman;
        });
    }

    /**
     * Reject pengajuan peminjaman (Diajukan → Ditolak).
     * - JANGAN sentuh stok sama sekali! Karena belum pernah di-decrement.
     */
    public function reject(Peminjaman $peminjaman, int $approverId, string $catatanAdmin): Peminjaman
    {
        if ($peminjaman->status !== PeminjamanStatus::Diajukan) {
            throw ValidationException::withMessages(['status' => 'Peminjaman tidak ditolak pada status ini.']);
        }
        if (trim($catatanAdmin) === '') {
            throw ValidationException::withMessages(['catatan_admin' => 'Alasan penolakan wajib diisi.']);
        }

        return DB::transaction(function () use ($peminjaman, $approverId, $catatanAdmin) {
            // 🚫 JANGAN increment stok (stok TIDAK pernah dikurangi di Diajukan!)
            $peminjaman->update([
                'status'         => PeminjamanStatus::Ditolak,
                'disetujui_oleh' => $approverId,
                'catatan_admin'  => $catatanAdmin,
            ]);

            return $peminjaman;
        });
    }

    /**
     * Verifikasi Keluar / Serahkan Barang ke Peminjam (Disetujui → Dipinjam).
     * - 🔴 DISINI BARU STOK DIKURANGI
     */
    public function serahkanBarang(Peminjaman $peminjaman): Peminjaman
    {
        if (!in_array($peminjaman->status, [PeminjamanStatus::Disetujui], true)) {
            throw ValidationException::withMessages(['status' => 'Hanya peminjaman status Disetujui yang dapat diserahkan.']);
        }

        $this->validateStock($peminjaman);

        return DB::transaction(function () use ($peminjaman) {
            foreach ($peminjaman->details as $detail) {
                $detail->barang->decrement('stok', $detail->jumlah);
            }

            $peminjaman->update([
                'status'          => PeminjamanStatus::Dipinjam,
                'tanggal_pinjam'  => $peminjaman->tanggal_pinjam ?? now()->toDateString(),
            ]);

            return $peminjaman;
        });
    }

    /**
     * Pengembalian Barang (Dipinjam / Terlambat → Dikembalikan).
     * - 🔴 STOK DITAMBAH (Dikembalikan ke rak)
     * - Jika terlambat → generate Denda
     * - Kondisi Rusak → update master barang.status = Rusak
     */
    public function kembalikanBarang(Peminjaman $peminjaman, array $conditions): Peminjaman
    {
        if (!in_array($peminjaman->status, [PeminjamanStatus::Dipinjam, PeminjamanStatus::Terlambat], true)) {
            throw ValidationException::withMessages(['status' => 'Hanya peminjaman status Dipinjam/Terlambat yang dapat dikembalikan.']);
        }

        $tanggalKembali = today();

        return DB::transaction(function () use ($peminjaman, $conditions, $tanggalKembali) {
            foreach ($peminjaman->details as $detail) {
                $kondisiRaw = $conditions[$detail->id] ?? KondisiBarang::Baik->value;
                $kondisi    = KondisiBarang::from($kondisiRaw);

                $detail->update(['kondisi_saat_kembali' => $kondisi]);
                $detail->barang->increment('stok', $detail->jumlah);

                // Barang yang kembali rusak → update master status
                if ($kondisi === KondisiBarang::Rusak) {
                    $detail->barang->update(['kondisi' => KondisiBarang::Rusak]);
                }
            }

            // Hapus QR code (sudah tidak berlaku)
            if ($peminjaman->qr_code) {
                $this->qrCodeService->delete($peminjaman->qr_code);
            }

            $peminjaman->update([
                'status'                  => PeminjamanStatus::Dikembalikan,
                'tanggal_kembali_aktual'  => $tanggalKembali,
                'qr_code'                 => null,
                'qr_token'                => null,
            ]);

            // Hitung denda jika terlambat
            if ($tanggalKembali->gt($peminjaman->tanggal_kembali_rencana)) {
                $hariTelat     = Carbon::parse($peminjaman->tanggal_kembali_rencana)->diffInDays($tanggalKembali);
                $tarifPerHari  = 5000;
                Denda::updateOrCreate(
                    ['peminjaman_id' => $peminjaman->id],
                    [
                        'jumlah_hari_telat' => $hariTelat,
                        'nominal_denda'     => $hariTelat * $tarifPerHari,
                        'status_bayar'      => DendaStatus::BelumBayar,
                    ]
                );
            }

            return $peminjaman;
        });
    }

    /**
     * Validasi stok untuk semua detail peminjaman.
     *
     * @throws ValidationException jika salah satu barang stok tidak cukup
     */
    public function validateStock(Peminjaman $peminjaman): void
    {
        $errors = [];
        foreach ($peminjaman->details as $detail) {
            $barang = $detail->barang;
            if (!$barang instanceof Barang) {
                continue;
            }
            if ($barang->stok < $detail->jumlah) {
                $errors[] = "Stok {$barang->nama_barang} (kode: {$barang->kode_barang}) tidak mencukupi: tersedia {$barang->stok}, diminta {$detail->jumlah}.";
            }
            if (!$barang->isTersedia()) {
                $status = $barang->status instanceof \App\Enums\StatusBarang ? $barang->status->label() : (string)$barang->status;
                $errors[] = "Barang {$barang->nama_barang} saat ini dalam status: {$status}. Tidak dapat dipinjam.";
            }
        }
        if (count($errors) > 0) {
            throw ValidationException::withMessages(['stok' => $errors]);
        }
    }
}
