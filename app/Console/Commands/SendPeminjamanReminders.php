<?php

namespace App\Console\Commands;

use App\Contracts\WhatsAppNotifierInterface;
use App\Enums\PeminjamanStatus;
use App\Enums\UserRole;
use App\Mail\PeminjamanReminderMail;
use App\Models\Guru;
use App\Models\Peminjaman;
use App\Models\Siswa;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

final class SendPeminjamanReminders extends Command
{
    protected $signature = 'sipbar:send-reminders
                            {--type= : Filter tipe: h1 | hari_ini | terlambat (default: SEMUA)}
                            {--dry-run : Simulasi — hanya output ke CLI, TIDAK mengirim pesan}
                            {--send-email=true : Kirim Email reminder via Mail driver}
                            {--send-wa=true : Kirim notifikasi WhatsApp via NotifierInterface}
                            {--limit= : Maksimal notifikasi per kategori (default: unlimited)}';

    protected $description = 'Kirim pengingat H-1, Hari-H, dan Terlambat via Email + WhatsApp gateway';

    /** @var array<string, array{total:int,email:int,wa:int,skip_email:int,skip_wa:int,errors:list<string>}> */
    private array $stats = [
        'h1'        => ['total' => 0, 'email' => 0, 'wa' => 0, 'skip_email' => 0, 'skip_wa' => 0, 'errors' => []],
        'hari_ini'  => ['total' => 0, 'email' => 0, 'wa' => 0, 'skip_email' => 0, 'skip_wa' => 0, 'errors' => []],
        'terlambat' => ['total' => 0, 'email' => 0, 'wa' => 0, 'skip_email' => 0, 'skip_wa' => 0, 'errors' => []],
    ];

    public function handle(WhatsAppNotifierInterface $wa): int
    {
        $start = microtime(true);
        $filterType = (string) $this->option('type');
        $isDry = (bool) $this->option('dry-run');
        $sendEmail = filter_var($this->option('send-email'), FILTER_VALIDATE_BOOLEAN);
        $sendWa = filter_var($this->option('send-wa'), FILTER_VALIDATE_BOOLEAN);
        $limit = $this->option('limit') ? (int) $this->option('limit') : null;

        $this->alert('🚀 SIPBAR Reminder Scheduler'.($isDry ? ' — [DRY RUN MODE]' : ' — Mode LIVE'));
        $this->line('Timestamp     : ' . now()->format('d M Y H:i:s T'));
        $this->line('Kirim Email   : '.($sendEmail ? '✅ AKTIF' : '🚫 NON-AKTIF'));
        $this->line('Kirim WA      : '.($sendWa ? '✅ AKTIF' : '🚫 NON-AKTIF'));
        $this->line('Limit / tipe  : '.($limit ?? 'TIDAK ADA BATAS'));

        if ($filterType !== '' && ! in_array($filterType, ['h1', 'hari_ini', 'terlambat'], true)) {
            $this->error('❌ Opsi --type tidak valid. Pilih salah satu: h1 | hari_ini | terlambat');

            return self::INVALID;
        }

        $today = Carbon::today();

        // ──────────────────────────────────────────────────────────────
        // 1. H-1: Besok = tanggal_kembali_rencana
        // ──────────────────────────────────────────────────────────────
        if ($filterType === '' || $filterType === 'h1') {
            $this->processCategory(
                category: 'h1',
                title: '🔶 [H-1] Besok Adalah Batas Pengembalian',
                query: Peminjaman::with(['user', 'details.barang'])
                    ->whereIn('status', [PeminjamanStatus::Disetujui, PeminjamanStatus::Dipinjam])
                    ->whereDate('tanggal_kembali_rencana', '=', $today->copy()->addDay()->toDateString()),
                sendEmail: $sendEmail,
                sendWa: $sendWa,
                isDry: $isDry,
                waNotifier: $wa,
                limit: $limit,
            );
        }

        // ──────────────────────────────────────────────────────────────
        // 2. HARI-H: Hari ini = batas terakhir pengembalian
        // ──────────────────────────────────────────────────────────────
        if ($filterType === '' || $filterType === 'hari_ini') {
            $this->processCategory(
                category: 'hari_ini',
                title: '🔵 [Hari-H] Batas Pengembalian Hari Ini',
                query: Peminjaman::with(['user', 'details.barang'])
                    ->whereIn('status', [PeminjamanStatus::Disetujui, PeminjamanStatus::Dipinjam])
                    ->whereDate('tanggal_kembali_rencana', '=', $today->toDateString()),
                sendEmail: $sendEmail,
                sendWa: $sendWa,
                isDry: $isDry,
                waNotifier: $wa,
                limit: $limit,
            );
        }

        // ──────────────────────────────────────────────────────────────
        // 3. TERLAMBAT: Rencana kembali < hari ini, status belum selesai
        // ──────────────────────────────────────────────────────────────
        if ($filterType === '' || $filterType === 'terlambat') {
            $this->processCategory(
                category: 'terlambat',
                title: '🔴 [TERLAMBAT] Melewati Batas Pengembalian',
                query: Peminjaman::with(['user', 'details.barang'])
                    ->whereIn('status', [PeminjamanStatus::Disetujui, PeminjamanStatus::Dipinjam, PeminjamanStatus::Terlambat])
                    ->whereDate('tanggal_kembali_rencana', '<', $today->toDateString()),
                sendEmail: $sendEmail,
                sendWa: $sendWa,
                isDry: $isDry,
                waNotifier: $wa,
                limit: $limit,
            );
        }

        // ──────────────────────────────────────────────────────────────
        // RINGKASAN AKHIR
        // ──────────────────────────────────────────────────────────────
        $this->newLine(2);
        $this->info('═══════════════════════════════════════════════════════');
        $this->info('📊 RINGKASAN PENGIRIMAN NOTIFIKASI');
        $this->info('═══════════════════════════════════════════════════════');

        $grandTotal = ['email' => 0, 'wa' => 0, 'total' => 0, 'errors' => 0];
        foreach ($this->stats as $typeKey => $s) {
            $label = match ($typeKey) {
                'h1'        => '🔶 H-1 (Besok Kembali)',
                'hari_ini'  => '🔵 Hari-H (Hari Ini)',
                'terlambat' => '🔴 Terlambat',
                default     => $typeKey,
            };
            $this->line("  {$label}");
            $this->line("     • Total data terpenuhi : {$s['total']}");
            $this->line("     • Email terkirim       : {$s['email']} (skip: {$s['skip_email']})");
            $this->line("     • WA    terkirim       : {$s['wa']} (skip: {$s['skip_wa']})");
            if (count($s['errors']) > 0) {
                $this->warn('     ⚠️  Errors ('.count($s['errors']).'):');
                foreach (array_slice($s['errors'], 0, 3) as $err) {
                    $this->warn("        - {$err}");
                }
                if (count($s['errors']) > 3) {
                    $this->warn('        … dan '.(count($s['errors']) - 3).' error lainnya…');
                }
            }
            $grandTotal['email'] += $s['email'];
            $grandTotal['wa']    += $s['wa'];
            $grandTotal['total'] += $s['total'];
            $grandTotal['errors'] += count($s['errors']);
            $this->newLine();
        }

        $dt = number_format(microtime(true) - $start, 2);
        $this->line("⏱️  Waktu eksekusi: {$dt}s");
        $this->info("✅ Selesai — TOTAL: {$grandTotal['total']} baris → Email:{$grandTotal['email']} / WA:{$grandTotal['wa']} / Errors:{$grandTotal['errors']}");

        return self::SUCCESS;
    }

    /**
     * @param  'h1'|'hari_ini'|'terlambat'  $category
     */
    private function processCategory(
        string $category,
        string $title,
        \Illuminate\Database\Eloquent\Builder $query,
        bool $sendEmail,
        bool $sendWa,
        bool $isDry,
        WhatsAppNotifierInterface $waNotifier,
        ?int $limit,
    ): void {
        $this->newLine();
        $this->info($title);
        $this->line(str_repeat('─', 60));

        $rows = $limit ? $query->limit($limit)->get() : $query->get();
        $this->stats[$category]['total'] = $rows->count();

        if ($rows->count() === 0) {
            $this->line('  (tidak ada data untuk kategori ini — skip)');

            return;
        }

        foreach ($rows as $idx => $peminjaman) {
            $user = $peminjaman->user;
            $noUrut = $idx + 1;

            $daysOverdue = $category === 'terlambat'
                ? max(0, (int) Carbon::today()->startOfDay()->diffInDays(Carbon::parse($peminjaman->tanggal_kembali_rencana)->startOfDay()))
                : 0;

            $rowLabel = "  [{$noUrut}/{$this->stats[$category]['total']}] #{$peminjaman->id} | ".($user?->name ?? 'User?');
            $this->line("{$rowLabel} | Status: {$peminjaman->status->label()} | Jatuh tempo: {$peminjaman->tanggal_kembali_rencana?->format('d/m/Y')}".($daysOverdue > 0 ? " ({$daysOverdue} hari telat)" : ''));

            // ───────────────── EMAIL ─────────────────
            if (! $user?->email || ! filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                $this->stats[$category]['skip_email']++;
                $this->line('        📧 Skip Email — alamat email user tidak valid / kosong.');
            } elseif (! $sendEmail) {
                $this->stats[$category]['skip_email']++;
                $this->line('        📧 Skip Email — flag --send-email=false');
            } elseif ($isDry) {
                $this->line("        📧 [DRY] Email yang AKAN dikirim ke <info>{$user->email}</info>");
            } else {
                try {
                    Mail::to($user->email)->send(new PeminjamanReminderMail($peminjaman, $category, $daysOverdue));
                    $this->stats[$category]['email']++;
                    $this->line("        📧 Email TERKIRIM ke <info>{$user->email}</info>");
                } catch (\Throwable $e) {
                    $this->stats[$category]['errors'][] = "Email #{$peminjaman->id}: {$e->getMessage()}";
                    $this->error("        📧 EMAIL GAGAL: {$e->getMessage()}");
                }
            }

            // ───────────────── WHATSAPP ─────────────────
            $noHp = (string) ($user?->no_hp ?? '');
            if ($noHp === '' && $user && $user->role === UserRole::Guru) {
                $noHp = (string) (Guru::where('user_id', $user->id)->first()?->no_hp ?? '');
            }
            if ($noHp === '' && $user && $user->role === UserRole::Siswa) {
                $noHp = (string) (Siswa::where('user_id', $user->id)->first()?->no_hp ?? '');
            }

            if ($noHp === '') {
                $this->stats[$category]['skip_wa']++;
                $this->line('        💬 Skip WA — nomor HP user tidak ditemukan.');
            } elseif (! $sendWa) {
                $this->stats[$category]['skip_wa']++;
                $this->line('        💬 Skip WA — flag --send-wa=false');
            } elseif ($isDry) {
                $this->line("        💬 [DRY] WA yang AKAN dikirim ke <info>{$noHp}</info>");
            } else {
                try {
                    $waMsg = $this->buildWaMessage($peminjaman, $category, $daysOverdue);
                    $result = $waNotifier->send($noHp, $waMsg, $peminjaman);
                    if (! empty($result['success'])) {
                        $this->stats[$category]['wa']++;
                        $this->line("        💬 WA TERKIRIM (gateway: {$result['gateway']} | msg-id: ".($result['message_id'] ?? '—').')');
                    } else {
                        $this->stats[$category]['errors'][] = "WA #{$peminjaman->id}: ".($result['error'] ?? 'Unknown WA error');
                        $this->warn("        💬 WA GAGAL: ".($result['error'] ?? '—'));
                    }
                } catch (\Throwable $e) {
                    $this->stats[$category]['errors'][] = "WA #{$peminjaman->id}: {$e->getMessage()}";
                    $this->error("        💬 WA EXCEPTION: {$e->getMessage()}");
                }
            }
        }
    }

    private function buildWaMessage(Peminjaman $p, string $category, int $daysOverdue): string
    {
        $nama = $p->user?->name ?? 'Peminjam';
        $statusLabel = $p->status->label();
        $listBarang = $p->details->map(fn ($d) => '• '.($d->barang?->nama_barang ?? 'Barang')." x{$d->jumlah}")->implode("\n");
        $tglKembali = $p->tanggal_kembali_rencana?->format('d/m/Y');
        $tglPinjam = $p->tanggal_pinjam?->format('d/m/Y') ?? '-';
        $keperluan = $p->keperluan ?? '-';
        $hariTelatLine = $daysOverdue > 0 ? "\n⏰ Hari Telat   : {$daysOverdue} hari" : '';

        $header = match ($category) {
            'h1'        => '*[Pengingat H-1 SIPBAR]*',
            'hari_ini'  => '*[Pengingat Hari-H SIPBAR]*',
            'terlambat' => '*⚠️ PERINGATAN TERLAMBAT SIPBAR*',
            default     => '*Notifikasi SIPBAR*',
        };

        $bodyTitle = match ($category) {
            'h1'        => "Halo *{$nama}*, ini adalah pengingat H-1 sebelum batas pengembalian barang pinjaman Anda.",
            'hari_ini'  => "Halo *{$nama}*, hari ini (*{$tglKembali}*) adalah batas pengembalian pinjaman Anda.",
            'terlambat' => "Halo *{$nama}*, PINJAMAN ANDA TERLAMBAT *{$daysOverdue} HARI*. Segera kembalikan!",
            default     => '',
        };

        return "{$header}\n\n{$bodyTitle}\n\n*Detail Peminjaman #{$p->id}:*\n📅 Tgl Pinjam   : {$tglPinjam}\n📅 Batas Kembali: {$tglKembali}\n📋 Status       : {$statusLabel}{$hariTelatLine}\n📝 Keperluan    : {$keperluan}\n\n*Daftar Barang:*\n{$listBarang}\n\nSilakan kembalikan barang ke petugas inventaris sekolah.\nTerima kasih atas perhatiannya.\n\n— Sistem SIPBAR Sekolah";
    }
}
