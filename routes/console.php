<?php

use App\Console\Commands\SendPeminjamanReminders;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ───────────────────────────────────────────────────────────────────────
// SIPBAR REMINDER SCHEDULER
// Dijalankan oleh CRON server: * * * * * cd /path-to-sipbar && php artisan schedule:run >> /dev/null 2>&1
// ───────────────────────────────────────────────────────────────────────

// 1. H-1 + Hari-H: dikirim PAGI JAM 08:00 setiap hari
//    Notifikasi besok kembali / hari ini batas kembali
Schedule::command(SendPeminjamanReminders::class, ['--type' => 'h1'])
    ->dailyAt('08:00')
    ->timezone('Asia/Jakarta')
    ->name('sipbar-reminder-h1')
    ->withoutOverlapping()
    ->onOneServer();

Schedule::command(SendPeminjamanReminders::class, ['--type' => 'hari_ini'])
    ->dailyAt('08:15')
    ->timezone('Asia/Jakarta')
    ->name('sipbar-reminder-hari-h')
    ->withoutOverlapping()
    ->onOneServer();

// 2. TERLAMBAT: dikirim 2x sehari (JAM 08:30 & JAM 13:00 siang setelah istirahat)
//    Memastikan siswa/guru yang telat 2x kali diperingatkan / hari.
Schedule::command(SendPeminjamanReminders::class, ['--type' => 'terlambat'])
    ->twiceDaily(8, 13, 30)
    ->timezone('Asia/Jakarta')
    ->name('sipbar-reminder-terlambat')
    ->withoutOverlapping()
    ->onOneServer();

// 3. Cleanup Activity Log setiap bulan 1 jam 02 pagi (hapus log > 6 bulan)
//    Pakai command bawaan package spatie/activitylog
if (class_exists(\Spatie\Activitylog\Commands\CleanActivitylogCommand::class)) {
    Schedule::command('activitylog:clean')
        ->monthlyOn(1, '02:00')
        ->timezone('Asia/Jakarta')
        ->name('clean-activity-log-monthly')
        ->withoutOverlapping();
}
