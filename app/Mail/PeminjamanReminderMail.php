<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Kirim email notifikasi reminder untuk 3 kategori:
 *  - 'h1'           : Besok adalah tanggal batas pengembalian barang (H-1)
 *  - 'hari_ini'     : Hari ini adalah batas pengembalian barang (Hari-H)
 *  - 'terlambat'    : Melewati batas pengembalian — ada denda per hari keterlambatan
 */
class PeminjamanReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  'h1'|'hari_ini'|'terlambat'  $type
     * @param  int  $daysOverdue  Hanya berlaku type='terlambat' — jumlah hari keterlambatan
     */
    public function __construct(
        public readonly Peminjaman $peminjaman,
        public readonly string $type,
        public readonly int $daysOverdue = 0,
    ) {
        //
    }

    public function envelope(): Envelope
    {
        $tanggal = $this->peminjaman->tanggal_kembali_rencana?->format('d M Y') ?? 'N/A';
        $identitas = $this->peminjaman->user?->name ?? 'Peminjam';

        $subject = match ($this->type) {
            'h1'         => "[Pengingat H-1] Pinjaman {$identitas} Kembali: {$tanggal}",
            'hari_ini'   => "[Pengingat Hari-H] Hari Ini Batas Kembali Pinjaman Anda ({$tanggal})",
            'terlambat'  => "[PERINGATAN TERLAMBAT {$this->daysOverdue} Hari] Segera Kembalikan Peminjaman #{$this->peminjaman->id}",
            default      => "Notifikasi Peminjaman Barang #{$this->peminjaman->id}",
        };

        return new Envelope(
            from: new Address(
                address: (string) config('mail.from.address', 'no-reply@sipbar.sch.id'),
                name: (string) config('mail.from.name', 'SIPBAR — Sistem Informasi Peminjaman Barang Sekolah')
            ),
            subject: $subject,
            tags: ['sipbar', 'reminder-' . $this->type, 'peminjaman-' . $this->peminjaman->id],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.peminjaman-reminder',
            with: [
                'peminjaman' => $this->peminjaman,
                'type' => $this->type,
                'daysOverdue' => $this->daysOverdue,
                'headerGradient' => match ($this->type) {
                    'h1'         => 'from-amber-500 to-orange-500',
                    'hari_ini'   => 'from-sky-500 to-blue-600',
                    'terlambat'  => 'from-rose-500 to-red-700',
                    default      => 'from-slate-500 to-slate-700',
                },
                'badgeText' => match ($this->type) {
                    'h1'         => 'H-1 — BESOK BATAS PENGEMBALIAN',
                    'hari_ini'   => 'HARI INI — BATAS PENGEMBALIAN',
                    'terlambat'  => 'TERLAMBAT — SEGERA KEMBALIKAN',
                    default      => 'NOTIFIKASI',
                },
                'ctaText' => match ($this->type) {
                    'h1', 'hari_ini' => 'Cek Detail Riwayat Peminjaman',
                    'terlambat'  => 'Lihat Detail & Hitung Denda',
                    default      => 'Lihat Selengkapnya',
                },
            ]
        );
    }
}
