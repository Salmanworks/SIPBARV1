<?php

namespace App\Http\Controllers;

use App\Enums\PeminjamanStatus;
use App\Http\Requests\ApprovePeminjamanRequest;
use App\Http\Requests\ProcessReturnRequest;
use App\Http\Requests\RejectPeminjamanRequest;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ApprovalController extends Controller
{
    public function __construct(
        private PeminjamanService $peminjamanService
    ) {}

    /**
     * Daftar pengajuan peminjaman status "Diajukan" (menunggu approval).
     */
    public function index(): View
    {
        $this->authorize('approve', Peminjaman::class);

        $peminjamans = Peminjaman::with(['details.barang', 'user.siswa'])
            ->where('status', PeminjamanStatus::Diajukan)
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('approval.index', compact('peminjamans'));
    }

    /**
     * Halaman proses peminjaman (QR code scan, detail transaksi).
     */
    public function showProcess(Peminjaman $peminjaman): View
    {
        $this->authorize('process', Peminjaman::class);

        $peminjaman->load(['details.barang', 'user.siswa', 'approver.guru']);

        return view('approval.process', compact('peminjaman'));
    }

    /**
     * Approve pengajuan → status Disetujui + Generate QR Code.
     */
    public function approve(ApprovePeminjamanRequest $request, Peminjaman $peminjaman): RedirectResponse
    {
        $this->authorize('approve', Peminjaman::class);

        $validated = $request->validated();

        try {
            $this->peminjamanService->approve(
                peminjaman:    $peminjaman,
                approverId:    auth()->id(),
                catatanAdmin:  $validated['catatan_admin'] ?? null
            );

            return back()->with('success', 'Peminjaman berhasil disetujui. QR Code telah dibuat.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyetujui peminjaman: '.$e->getMessage());
        }
    }

    /**
     * Reject pengajuan → status Ditolak.
     */
    public function reject(RejectPeminjamanRequest $request, Peminjaman $peminjaman): RedirectResponse
    {
        $this->authorize('approve', Peminjaman::class);

        $validated = $request->validated();

        try {
            $this->peminjamanService->reject(
                peminjaman:   $peminjaman,
                approverId:   auth()->id(),
                catatanAdmin: $validated['catatan_admin']
            );

            return back()->with('success', 'Peminjaman berhasil ditolak.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menolak peminjaman: '.$e->getMessage());
        }
    }

    /**
     * Proses penyerahan barang / verifikasi keluar (Disetujui → Dipinjam).
     */
    public function processBorrowing(Peminjaman $peminjaman): RedirectResponse
    {
        $this->authorize('process', Peminjaman::class);

        try {
            $this->peminjamanService->serahkanBarang($peminjaman);

            return back()->with('success', 'Barang berhasil dipinjamkan. Status: Dipinjam.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses peminjaman: '.$e->getMessage());
        }
    }

    /**
     * Proses pengembalian barang (Dipinjam/Terlambat → Dikembalikan + Denda if late).
     */
    public function processReturn(ProcessReturnRequest $request, Peminjaman $peminjaman): RedirectResponse
    {
        $this->authorize('process', Peminjaman::class);

        $validated = $request->validated();

        try {
            $this->peminjamanService->kembalikanBarang($peminjaman, $validated['kondisi']);

            return back()->with('success', 'Peminjaman berhasil dikembalikan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memproses pengembalian: '.$e->getMessage());
        }
    }
}
