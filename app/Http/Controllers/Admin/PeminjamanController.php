<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PeminjamanStatus;
use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Peminjaman::with(['user', 'details.barang', 'approver']);

        if ($search = $request->string('search')->trim()->value()) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->value());
        }

        $peminjamans = $query->latest()->paginate(10)->withQueryString();

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function show(Peminjaman $peminjaman): View
    {
        $peminjaman->load(['user', 'details.barang', 'approver', 'denda']);

        return view('peminjaman.detail', compact('peminjaman'));
    }

    public function approval(): View
    {
        $peminjamans = Peminjaman::with(['user', 'details.barang'])
            ->where('status', PeminjamanStatus::Diajukan)
            ->latest()
            ->paginate(10);

        return view('peminjaman.approval', compact('peminjamans'));
    }

    public function approve(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== PeminjamanStatus::Diajukan) {
            return back()->with('error', 'Peminjaman tidak dapat disetujui.');
        }

        foreach ($peminjaman->details as $detail) {
            if ($detail->barang->stok < $detail->jumlah) {
                return back()->with('error', "Stok {$detail->barang->nama_barang} tidak mencukupi.");
            }
        }

        $peminjaman->update([
            'status' => PeminjamanStatus::Disetujui,
            'disetujui_oleh' => auth()->id(),
            'catatan_admin' => $request->string('catatan_admin')->value() ?: null,
        ]);

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== PeminjamanStatus::Diajukan) {
            return back()->with('error', 'Peminjaman tidak dapat ditolak.');
        }

        $peminjaman->update([
            'status' => PeminjamanStatus::Ditolak,
            'disetujui_oleh' => auth()->id(),
            'catatan_admin' => $request->validate([
                'catatan_admin' => ['required', 'string', 'max:500'],
            ])['catatan_admin'],
        ]);

        return back()->with('success', 'Peminjaman ditolak.');
    }
}
