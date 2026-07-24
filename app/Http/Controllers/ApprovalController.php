<?php

namespace App\Http\Controllers;

use App\Enums\PeminjamanStatus;
use App\Http\Requests\ApprovalRequest;
use App\Models\Peminjaman;
use App\Services\QRCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function __construct(
        private QRCodeService $qrCodeService
    ) {}

    public function index()
    {
        $this->authorize('approve', Peminjaman::class);

        $peminjamans = Peminjaman::with(['details.barang', 'user.siswa'])
            ->where('status', PeminjamanStatus::Diajukan)
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('approval.index', compact('peminjamans'));
    }

    public function showProcess(Peminjaman $peminjaman)
    {
        $this->authorize('process', Peminjaman::class);

        $peminjaman->load(['details.barang', 'user.siswa', 'approver.guru']);

        return view('approval.process', compact('peminjaman'));
    }

    public function approve(Request $request, Peminjaman $peminjaman)
    {
        $this->authorize('approve', Peminjaman::class);

        if ($peminjaman->status !== PeminjamanStatus::Diajukan) {
            return back()->with('error', 'Peminjaman tidak dapat disetujui pada status ini.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Update peminjaman status
            $peminjaman->update([
                'status' => PeminjamanStatus::Disetujui,
                'disetujui_oleh' => auth()->id(),
                'catatan_admin' => $request->catatan_admin,
            ]);

            // Generate QR Code
            $qrPath = $this->qrCodeService->generateForPeminjaman($peminjaman->id);
            $peminjaman->update(['qr_code' => $qrPath]);

            DB::commit();

            return back()->with('success', 'Peminjaman berhasil disetujui. QR Code telah dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyetujui peminjaman.');
        }
    }

    public function reject(Request $request, Peminjaman $peminjaman)
    {
        $this->authorize('approve', Peminjaman::class);

        if ($peminjaman->status !== PeminjamanStatus::Diajukan) {
            return back()->with('error', 'Peminjaman tidak dapat ditolak pada status ini.');
        }

        $request->validate([
            'catatan_admin' => 'required|string|min:5|max:500',
        ], [
            'catatan_admin.required' => 'Alasan penolakan harus diisi',
            'catatan_admin.min' => 'Alasan penolakan minimal 5 karakter',
        ]);

        try {
            DB::beginTransaction();

            // Restore stock
            foreach ($peminjaman->details as $detail) {
                $detail->barang->increment('stok', $detail->jumlah);
            }

            // Update peminjaman status
            $peminjaman->update([
                'status' => PeminjamanStatus::Ditolak,
                'catatan_admin' => $request->catatan_admin,
            ]);

            DB::commit();

            return back()->with('success', 'Peminjaman berhasil ditolak.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menolak peminjaman.');
        }
    }

    public function processBorrowing(Peminjaman $peminjaman)
    {
        $this->authorize('process', Peminjaman::class);

        if ($peminjaman->status !== PeminjamanStatus::Disetujui) {
            return back()->with('error', 'Peminjaman tidak dapat diproses pada status ini.');
        }

        try {
            DB::beginTransaction();

            $peminjaman->update([
                'status' => PeminjamanStatus::Dipinjam,
            ]);

            DB::commit();

            return back()->with('success', 'Barang berhasil dipinjamkan. Status: Dipinjam.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses peminjaman.');
        }
    }

    public function processReturn(Request $request, Peminjaman $peminjaman)
    {
        $this->authorize('process', Peminjaman::class);

        if (!in_array($peminjaman->status, [PeminjamanStatus::Dipinjam, PeminjamanStatus::Terlambat])) {
            return back()->with('error', 'Peminjaman tidak dapat dikembalikan pada status ini.');
        }

        $request->validate([
            'kondisi' => 'required|array min:1',
            'kondisi.*.detail_id' => 'required|exists:detail_peminjamans,id',
            'kondisi.*.kondisi' => 'required|in:baik,rusak',
        ]);

        try {
            DB::beginTransaction();

            // Update detail conditions
            foreach ($request->kondisi as $item) {
                $detail = $peminjaman->details()->findOrFail($item['detail_id']);
                $detail->update([
                    'kondisi_saat_kembali' => $item['kondisi'],
                ]);

                // Restore stock
                $detail->barang->increment('stok', $detail->jumlah);
            }

            // Delete QR code
            if ($peminjaman->qr_code) {
                $this->qrCodeService->delete($peminjaman->qr_code);
            }

            // Update peminjaman status
            $peminjaman->update([
                'status' => PeminjamanStatus::Dikembalikan,
                'tanggal_kembali_aktual' => now()->toDateString(),
                'qr_code' => null,
            ]);

            DB::commit();

            return back()->with('success', 'Peminjaman berhasil dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pengembalian.');
        }
    }
}
