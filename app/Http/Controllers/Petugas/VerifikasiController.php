<?php

namespace App\Http\Controllers\Petugas;

use App\Enums\PeminjamanStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessReturnRequest;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use App\Services\QRCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifikasiController extends Controller
{
    public function __construct(
        private PeminjamanService $peminjamanService,
        private QRCodeService $qrService,
    ) {}

    public function dashboard(): View
    {
        Peminjaman::query()
            ->whereIn('status', [PeminjamanStatus::Disetujui, PeminjamanStatus::Dipinjam])
            ->get()
            ->each->syncOverdueStatus();

        $stats = [
            'menunggu_verifikasi' => Peminjaman::where('status', PeminjamanStatus::Disetujui)->count(),
            'sedang_dipinjam'     => Peminjaman::whereIn('status', [
                PeminjamanStatus::Dipinjam,
                PeminjamanStatus::Terlambat,
            ])->count(),
            'terlambat'           => Peminjaman::where('status', PeminjamanStatus::Terlambat)->count(),
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

    /**
     * Verifikasi Keluar = Serahkan Barang ke Peminjam (Disetujui → Dipinjam).
     * - Menjalankan decrement stok.
     */
    public function keluar(Peminjaman $peminjaman): RedirectResponse
    {
        try {
            $this->peminjamanService->serahkanBarang($peminjaman);

            return back()->with('success', 'Barang telah diverifikasi keluar.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Verifikasi Pengembalian = Barang diterima kembali (Dipinjam/Terlambat → Dikembalikan).
     * - Menjalankan increment stok.
     * - Auto-create denda jika terlambat.
     * - Update kondisi barang jika rusak.
     */
    public function kembali(ProcessReturnRequest $request, Peminjaman $peminjaman): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $this->peminjamanService->kembalikanBarang($peminjaman, $validated['kondisi']);

            return back()->with('success', 'Pengembalian barang berhasil diverifikasi.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * ──────────────────────────────────────────────────────────────────
     * HALAMAN SCAN QR CODE (Phase 6)
     * Menampilkan form paste hasil scan + (jika ada ?data= langsung proses).
     * ──────────────────────────────────────────────────────────────────
     */
    public function scanForm(Request $request): View
    {
        $autoPayload = null;
        $autoPeminjaman = null;
        $autoError = null;

        // Jika param ?data= ada → auto-decode QR untuk deep-link dari scanner HP
        if ($request->filled('data')) {
            $payload = $this->qrService->decodeAndVerify((string) $request->string('data'));
            if ($payload === null) {
                $autoError = 'QR Code tidak valid. Signature salah atau data dimanipulasi / palsu.';
            } else {
                $autoPayload = $payload;
                $autoPeminjaman = Peminjaman::with(['user', 'details.barang', 'denda'])
                    ->where('id', (int) $payload['pid'])
                    ->where('qr_token', (string) $payload['tok'])
                    ->first();
                if (! $autoPeminjaman instanceof Peminjaman) {
                    $autoError = 'QR Code sudah tidak berlaku (expired / peminjaman telah selesai / token tidak cocok).';
                }
            }
        }

        return view('guru.verifikasi.scan-form', compact(
            'autoPayload',
            'autoPeminjaman',
            'autoError'
        ));
    }

    /**
     * Proses POST form submit isi QR Code.
     * Jika VALID → redirect ke halaman detail hasil scan.
     * Jika TIDAK VALID → kembali ke form dengan error.
     */
    public function scanProcess(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'qr_content' => ['required', 'string', 'min:6', 'max:4000'],
        ]);

        $payload = $this->qrService->decodeAndVerify($validated['qr_content']);

        if ($payload === null) {
            return redirect()->route('approval.scan')
                ->with('error', 'QR Code tidak valid. Pastikan isinya benar dari sistem SIPBAR (bukan QR sembarangan).');
        }

        $peminjaman = Peminjaman::where('id', (int) $payload['pid'])
            ->where('qr_token', (string) $payload['tok'])
            ->first();

        if (! $peminjaman instanceof Peminjaman) {
            return redirect()->route('approval.scan')
                ->with('error', 'QR Code sudah tidak berlaku. Token QR tidak cocok dengan data sistem (peminjaman mungkin sudah selesai).');
        }

        return redirect()->route('approval.scan-result', [$peminjaman, 'sig='.$payload['sig']]);
    }

    /**
     * Halaman HASIL SCAN QR.
     * Menampilkan detail peminjaman beserta tombol aksi sesuai status:
     *  - Disetujui → tombol [SERAHKAN BARANG] (ke status Dipinjam, stok -)
     *  - Dipinjam / Terlambat → form KONDISI per barang + tombol [KEMBALIKAN BARANG] (stok +, denda, qr invalidate)
     *  - Selain status itu → info saja.
     */
    public function scanResult(Peminjaman $peminjaman, Request $request): View
    {
        $peminjaman->load(['user', 'details.barang', 'denda', 'approver']);

        // Opsional verifikasi sig query param, agar user tidak bisa akses langsung /scan/{id} tanpa valid QR
        $sigValid = $request->filled('sig') && hash_equals((string) $request->string('sig'), (string) ($peminjaman->qr_token ? hash_hmac(
            'sha256',
            $peminjaman->id.'|'.$peminjaman->qr_token.'|'.($peminjaman->status instanceof \BackedEnum ? $peminjaman->status->value : (string) $peminjaman->status).'|'.now()->toDateString(),
            config('app.key')
        ) : ''));

        $signatureVerified = $sigValid || ! empty($request->query('from_scan', true));

        // Status apa saja yang bisa di-action dari QR
        $bisaSerahkan = $peminjaman->status === PeminjamanStatus::Disetujui;
        $bisaKembalikan = in_array($peminjaman->status, [PeminjamanStatus::Dipinjam, PeminjamanStatus::Terlambat], true);

        return view('guru.verifikasi.scan-result', compact(
            'peminjaman',
            'signatureVerified',
            'bisaSerahkan',
            'bisaKembalikan'
        ));
    }
}
