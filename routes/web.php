<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\BarangController as AdminBarangController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Peminjam\PengajuanController;
use App\Http\Controllers\Peminjam\RiwayatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Petugas\VerifikasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('home');

Route::middleware(['auth', 'verified', 'first.login'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('barang', AdminBarangController::class);
        Route::resource('kategori', AdminKategoriController::class)->except(['show']);

        // Guru + Import & template
        Route::get('guru/download-template', [GuruController::class, 'downloadTemplate'])->name('guru.download-template');
        Route::post('guru/import', [GuruController::class, 'import'])->name('guru.import');
        Route::resource('guru', GuruController::class)->except(['show']);

        // Siswa + Import & template
        Route::get('siswa/download-template', [SiswaController::class, 'downloadTemplate'])->name('siswa.download-template');
        Route::post('siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
        Route::resource('siswa', SiswaController::class)->except(['show']);

        Route::resource('users', UserController::class)->except(['show']);
        Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
        Route::get('peminjaman/approval', [AdminPeminjamanController::class, 'approval'])->name('peminjaman.approval');
        Route::post('peminjaman/{peminjaman}/approve', [AdminPeminjamanController::class, 'approve'])->name('peminjaman.approve');
        Route::post('peminjaman/{peminjaman}/reject', [AdminPeminjamanController::class, 'reject'])->name('peminjaman.reject');
        Route::resource('peminjaman', AdminPeminjamanController::class)->only(['index', 'show']);
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    Route::middleware('role:guru,admin')->prefix('approval')->name('approval.')->group(function () {
        Route::get('/', [ApprovalController::class, 'index'])->name('index');
        Route::post('{peminjaman}/approve', [ApprovalController::class, 'approve'])->name('approve');
        Route::post('{peminjaman}/reject', [ApprovalController::class, 'reject'])->name('reject');
        Route::post('{peminjaman}/process-borrowing', [ApprovalController::class, 'processBorrowing'])->name('process-borrowing');
        Route::post('{peminjaman}/process-return', [ApprovalController::class, 'processReturn'])->name('process-return');
        Route::get('{peminjaman}/process', [ApprovalController::class, 'showProcess'])->name('process');
    });

    Route::middleware('role:siswa,admin,guru')->prefix('peminjam')->name('peminjam.')->group(function () {
        Route::get('dashboard', [PengajuanController::class, 'dashboard'])->name('dashboard');
        Route::get('pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
        Route::get('riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('riwayat/{peminjaman}', [RiwayatController::class, 'show'])->name('riwayat.show');
    });

    Route::middleware('role:siswa')->prefix('peminjaman')->name('peminjaman.')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('index');
        Route::get('/create', [PeminjamanController::class, 'create'])->name('create');
        Route::post('/', [PeminjamanController::class, 'store'])->name('store');
        Route::post('{peminjaman}/cancel', [PeminjamanController::class, 'cancel'])->name('cancel');
    });

    Route::middleware('role:siswa,guru,admin')->prefix('peminjaman')->name('peminjaman.')->group(function () {
        Route::get('{peminjaman}', [PeminjamanController::class, 'show'])->name('show');
    });
});

// Authentication routes
use App\Http\Controllers\Auth\LoginController;
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.store');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

require __DIR__.'/settings.php';
