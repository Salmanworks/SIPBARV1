<?php

namespace App\Http\Controllers;

use App\Enums\PeminjamanStatus;
use App\Http\Requests\StorePeminjamanRequest;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Services\QRCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PeminjamanController extends Controller
{
    public function __construct(
        private QRCodeService $qrCodeService
    ) {}

    public function index()
    {
        $user = auth()->user();
        
        $peminjamans = Peminjaman::with(['details.barang', 'approver'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('peminjaman.student-index', compact('peminjamans'));
    }

    public function create(Request $request)
    {
        $kategoris = \App\Models\Kategori::orderBy('nama_kategori')->get();

        $query = Barang::with('kategori')
            ->where('stok', '>', 0)
            ->where('kondisi', 'baik');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'LIKE', "%{$search}%")
                  ->orWhere('kode_barang', 'LIKE', "%{$search}%")
                  ->orWhere('lokasi', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $barangs = $query->orderBy('nama_barang')->paginate(12)->withQueryString();

        return view('peminjaman.student-create', compact('barangs', 'kategoris'));
    }

    public function store(StorePeminjamanRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();
            
            // Validate stock availability
            foreach ($request->barang as $item) {
                $barang = Barang::findOrFail($item['id']);
                if ($barang->stok < $item['jumlah']) {
                    throw ValidationException::withMessages([
                        'barang' => "Stok {$barang->nama_barang} tidak mencukupi. Tersedia: {$barang->stok}"
                    ]);
                }
            }

            // Create peminjaman
            $peminjaman = Peminjaman::create([
                'user_id' => $user->id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'keperluan' => $request->keperluan,
                'status' => PeminjamanStatus::Diajukan,
            ]);

            // Create detail peminjaman and update stock
            foreach ($request->barang as $item) {
                $barang = Barang::findOrFail($item['id']);
                
                $peminjaman->details()->create([
                    'barang_id' => $item['id'],
                    'jumlah' => $item['jumlah'],
                ]);

                // Deduct stock
                $barang->decrement('stok', $item['jumlah']);
            }

            DB::commit();

            return redirect()
                ->route('peminjaman.show', $peminjaman)
                ->with('success', 'Pengajuan peminjaman berhasil dibuat. Menunggu persetujuan guru.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($e instanceof ValidationException) {
                throw $e;
            }

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat pengajuan peminjaman.');
        }
    }

    public function show(Peminjaman $peminjaman)
    {
        $this->authorize('view', $peminjaman);

        $peminjaman->load(['details.barang.kategori', 'user.siswa', 'approver.guru']);

        return view('peminjaman.student-show', compact('peminjaman'));
    }

    public function cancel(Peminjaman $peminjaman)
    {
        $this->authorize('cancel', $peminjaman);

        if (!in_array($peminjaman->status, [PeminjamanStatus::Diajukan, PeminjamanStatus::Disetujui])) {
            return back()->with('error', 'Peminjaman tidak dapat dibatalkan pada status ini.');
        }

        try {
            DB::beginTransaction();

            // Restore stock
            foreach ($peminjaman->details as $detail) {
                $detail->barang->increment('stok', $detail->jumlah);
            }

            // Delete QR code if exists
            if ($peminjaman->qr_code) {
                $this->qrCodeService->delete($peminjaman->qr_code);
            }

            $peminjaman->update([
                'status' => PeminjamanStatus::Ditolak,
                'catatan_admin' => 'Dibatalkan oleh peminjam',
            ]);

            DB::commit();

            return back()->with('success', 'Peminjaman berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membatalkan peminjaman.');
        }
    }
}
