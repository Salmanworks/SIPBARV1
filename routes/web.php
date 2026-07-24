<?php

use App\Http\Controllers\Admin\BarangController as AdminBarangController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('barang', AdminBarangController::class);
        Route::resource('kategori', AdminKategoriController::class)->except(['show']);
        Route::resource('users', UserController::class)->except(['show']);
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
        Route::get('{peminjaman}', [PeminjamanController::class, 'show'])->name('show');
        Route::post('{peminjaman}/cancel', [PeminjamanController::class, 'cancel'])->name('cancel');
    });
});

// Authentication routes
use App\Http\Controllers\Auth\LoginController;
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.store');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

require __DIR__.'/settings.php';
