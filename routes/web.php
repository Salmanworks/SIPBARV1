<?php

use App\Http\Controllers\Admin\BarangController as AdminBarangController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Peminjam\PengajuanController;
use App\Http\Controllers\Peminjam\RiwayatController;
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

    Route::middleware('role:petugas,admin')->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('dashboard', [VerifikasiController::class, 'dashboard'])->name('dashboard');
        Route::get('verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::get('verifikasi/{peminjaman}', [VerifikasiController::class, 'show'])->name('verifikasi.show');
        Route::post('verifikasi/{peminjaman}/keluar', [VerifikasiController::class, 'keluar'])->name('verifikasi.keluar');
        Route::post('verifikasi/{peminjaman}/kembali', [VerifikasiController::class, 'kembali'])->name('verifikasi.kembali');
    });

    Route::middleware('role:peminjam,admin,petugas')->prefix('peminjam')->name('peminjam.')->group(function () {
        Route::get('dashboard', [PengajuanController::class, 'dashboard'])->name('dashboard');
        Route::get('pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
        Route::get('riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('riwayat/{peminjaman}', [RiwayatController::class, 'show'])->name('riwayat.show');
    });
});

require __DIR__.'/settings.php';
