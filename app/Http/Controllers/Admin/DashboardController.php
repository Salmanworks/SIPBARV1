<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PeminjamanStatus;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        // Remove sync to prevent timeout - status will be calculated on display
        // Peminjaman::query()
        //     ->whereIn('status', [PeminjamanStatus::Disetujui, PeminjamanStatus::Dipinjam])
        //     ->get()
        //     ->each->syncOverdueStatus();

        $stats = [
            'total_barang' => Barang::count(),
            'total_kategori' => Kategori::count(),
            'total_user' => User::count(),
            'total_peminjaman' => Peminjaman::count(),
            'sedang_dipinjam' => Peminjaman::whereIn('status', [
                PeminjamanStatus::Dipinjam,
                PeminjamanStatus::Terlambat,
            ])->count(),
            'terlambat' => Peminjaman::where('status', PeminjamanStatus::Terlambat)->count(),
            'menunggu_approval' => Peminjaman::where('status', PeminjamanStatus::Diajukan)->count(),
        ];

        $recentPeminjamans = Peminjaman::with(['user', 'details.barang'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'recentPeminjamans'));
    }
}
