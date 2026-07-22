<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiwayatController extends Controller
{
    public function index(Request $request): View
    {
        $query = auth()->user()->peminjamans()->with(['details.barang', 'denda']);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->value());
        }

        $peminjamans = $query->latest()->paginate(10)->withQueryString();

        return view('peminjam.riwayat.index', compact('peminjamans'));
    }

    public function show(Peminjaman $peminjaman): View
    {
        abort_unless($peminjaman->user_id === auth()->id(), 403);

        $peminjaman->load(['details.barang', 'approver', 'denda']);

        return view('peminjam.riwayat.show', compact('peminjaman'));
    }
}
