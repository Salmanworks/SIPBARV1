<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PeminjamanStatus;
use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function __construct(
        private PeminjamanService $peminjamanService
    ) {}

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
        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            $this->peminjamanService->approve(
                peminjaman:   $peminjaman,
                approverId:   auth()->id(),
                catatanAdmin: $validated['catatan_admin'] ?? null
            );

            return back()->with('success', 'Peminjaman disetujui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function reject(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $validated = $request->validate([
            'catatan_admin' => ['required', 'string', 'max:500'],
        ]);

        try {
            $this->peminjamanService->reject(
                peminjaman:   $peminjaman,
                approverId:   auth()->id(),
                catatanAdmin: $validated['catatan_admin']
            );

            return back()->with('success', 'Peminjaman ditolak.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
