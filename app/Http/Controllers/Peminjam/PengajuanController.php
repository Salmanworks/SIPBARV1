<?php

namespace App\Http\Controllers\Peminjam;

use App\Enums\PeminjamanStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanPeminjamanRequest;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengajuanController extends Controller
{
    public function dashboard(): View
    {
        $user = auth()->user();

        Peminjaman::where('user_id', $user->id)
            ->whereIn('status', [PeminjamanStatus::Disetujui, PeminjamanStatus::Dipinjam])
            ->get()
            ->each->syncOverdueStatus();

        $stats = [
            'total_pengajuan' => $user->peminjamans()->count(),
            'menunggu' => $user->peminjamans()->where('status', PeminjamanStatus::Diajukan)->count(),
            'aktif' => $user->peminjamans()->whereIn('status', [
                PeminjamanStatus::Dipinjam,
                PeminjamanStatus::Terlambat,
            ])->count(),
            'terlambat' => $user->peminjamans()->where('status', PeminjamanStatus::Terlambat)->count(),
        ];

        $recent = $user->peminjamans()->with('details.barang')->latest()->limit(5)->get();

        return view('dashboard.peminjam', compact('stats', 'recent'));
    }

    public function create(Request $request): View
    {
        $query = Barang::with('kategori')->where('stok', '>', 0)->where('kondisi', 'baik');

        if ($search = $request->string('search')->trim()->value()) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        if ($kategoriId = $request->integer('kategori_id')) {
            $query->where('kategori_id', $kategoriId);
        }

        $barangs = $query->orderBy('nama_barang')->paginate(12)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('peminjaman.create', compact('barangs', 'kategoris'));
    }

    /**
     * Simpan pengajuan peminjaman dari Siswa (pakai PengajuanPeminjamanRequest).
     * Validasi stok per barang sebelum create.
     */
    public function store(PengajuanPeminjamanRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        foreach ($validated['barang_id'] as $barangId) {
            $barang = Barang::findOrFail($barangId);
            $jumlah = (int) ($validated['jumlah'][$barangId] ?? 0);

            if ($jumlah < 1) {
                return back()->withInput()->with('error', "Jumlah untuk {$barang->nama_barang} tidak valid.");
            }

            if ($barang->stok < $jumlah) {
                return back()->withInput()->with('error', "Stok {$barang->nama_barang} tidak mencukupi.");
            }
        }

        $peminjaman = Peminjaman::create([
            'user_id' => auth()->id(),
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_kembali_rencana' => $validated['tanggal_kembali_rencana'],
            'keperluan' => $validated['keperluan'],
            'status' => PeminjamanStatus::Diajukan,
        ]);

        foreach ($validated['barang_id'] as $barangId) {
            $peminjaman->details()->create([
                'barang_id' => $barangId,
                'jumlah' => (int) $validated['jumlah'][$barangId],
            ]);
        }

        return redirect()->route('peminjam.dashboard')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }
}
