<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PeminjamanStatus;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $from = $request->date('dari') ?? now()->startOfMonth();
        $to = $request->date('sampai') ?? now();

        $query = Peminjaman::with(['user', 'details.barang', 'denda'])
            ->whereBetween('tanggal_pinjam', [$from, $to]);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->value());
        }

        $peminjamans = $query->latest()->paginate(15)->withQueryString();

        $summary = [
            'total' => (clone $query)->count(),
            'diajukan' => Peminjaman::whereBetween('tanggal_pinjam', [$from, $to])
                ->where('status', PeminjamanStatus::Diajukan)->count(),
            'dipinjam' => Peminjaman::whereBetween('tanggal_pinjam', [$from, $to])
                ->whereIn('status', [PeminjamanStatus::Dipinjam, PeminjamanStatus::Terlambat])->count(),
            'dikembalikan' => Peminjaman::whereBetween('tanggal_pinjam', [$from, $to])
                ->where('status', PeminjamanStatus::Dikembalikan)->count(),
            'terlambat' => Peminjaman::whereBetween('tanggal_pinjam', [$from, $to])
                ->where('status', PeminjamanStatus::Terlambat)->count(),
            'total_barang' => Barang::count(),
        ];

        return view('laporan.index', compact('peminjamans', 'summary', 'from', 'to'));
    }
}
