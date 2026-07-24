<?php

namespace App\Http\Controllers\Petugas;

use App\Enums\DendaStatus;
use App\Enums\KondisiBarang;
use App\Enums\PeminjamanStatus;
use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class VerifikasiController extends Controller
{
    public function dashboard(): View
    {
        Peminjaman::query()
            ->whereIn('status', [PeminjamanStatus::Disetujui, PeminjamanStatus::Dipinjam])
            ->get()
            ->each->syncOverdueStatus();

        $stats = [
            'menunggu_verifikasi' => Peminjaman::where('status', PeminjamanStatus::Disetujui)->count(),
            'sedang_dipinjam' => Peminjaman::whereIn('status', [
                PeminjamanStatus::Dipinjam,
                PeminjamanStatus::Terlambat,
            ])->count(),
            'terlambat' => Peminjaman::where('status', PeminjamanStatus::Terlambat)->count(),
            'pengembalian_hari_ini' => Peminjaman::whereDate('tanggal_kembali_rencana', today())
                ->whereIn('status', [PeminjamanStatus::Dipinjam, PeminjamanStatus::Terlambat])
                ->count(),
        ];

        $pendingReturns = Peminjaman::with(['user', 'details.barang'])
            ->whereIn('status', [PeminjamanStatus::Dipinjam, PeminjamanStatus::Terlambat])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.guru', compact('stats', 'pendingReturns'));
    }

    public function index(Request $request): View
    {
        $query = Peminjaman::with(['user', 'details.barang'])
            ->whereIn('status', [
                PeminjamanStatus::Disetujui,
                PeminjamanStatus::Dipinjam,
                PeminjamanStatus::Terlambat,
            ]);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->value());
        }

        $peminjamans = $query->latest()->paginate(10)->withQueryString();

        return view('guru.verifikasi.index', compact('peminjamans'));
    }

    public function show(Peminjaman $peminjaman): View
    {
        $peminjaman->load(['user', 'details.barang', 'denda']);

        return view('guru.verifikasi.show', compact('peminjaman'));
    }

    public function keluar(Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== PeminjamanStatus::Disetujui) {
            return back()->with('error', 'Status peminjaman tidak valid untuk verifikasi keluar.');
        }

        foreach ($peminjaman->details as $detail) {
            if ($detail->barang->stok < $detail->jumlah) {
                return back()->with('error', "Stok {$detail->barang->nama_barang} tidak mencukupi.");
            }
        }

        foreach ($peminjaman->details as $detail) {
            $detail->barang->decrement('stok', $detail->jumlah);
        }

        $peminjaman->update(['status' => PeminjamanStatus::Dipinjam]);

        return back()->with('success', 'Barang telah diverifikasi keluar.');
    }

    public function kembali(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        if (! in_array($peminjaman->status, [PeminjamanStatus::Dipinjam, PeminjamanStatus::Terlambat], true)) {
            return back()->with('error', 'Status peminjaman tidak valid untuk pengembalian.');
        }

        $validated = $request->validate([
            'kondisi' => ['required', 'array'],
            'kondisi.*' => ['required', 'in:baik,rusak'],
        ]);

        foreach ($peminjaman->details as $detail) {
            $kondisi = KondisiBarang::from($validated['kondisi'][$detail->id]);
            $detail->update(['kondisi_saat_kembali' => $kondisi]);
            $detail->barang->increment('stok', $detail->jumlah);

            if ($kondisi === KondisiBarang::Rusak) {
                $detail->barang->update(['kondisi' => KondisiBarang::Rusak]);
            }
        }

        $tanggalKembali = today();
        $peminjaman->update([
            'status' => PeminjamanStatus::Dikembalikan,
            'tanggal_kembali_aktual' => $tanggalKembali,
        ]);

        if ($tanggalKembali->gt($peminjaman->tanggal_kembali_rencana)) {
            $hariTelat = Carbon::parse($peminjaman->tanggal_kembali_rencana)->diffInDays($tanggalKembali);
            $tarifPerHari = 5000;

            Denda::updateOrCreate(
                ['peminjaman_id' => $peminjaman->id],
                [
                    'jumlah_hari_telat' => $hariTelat,
                    'nominal_denda' => $hariTelat * $tarifPerHari,
                    'status_bayar' => DendaStatus::BelumBayar,
                ]
            );
        }

        return back()->with('success', 'Pengembalian barang berhasil diverifikasi.');
    }
}
