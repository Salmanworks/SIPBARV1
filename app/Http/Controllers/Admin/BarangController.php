<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function index(Request $request): View
    {
        $query = Barang::with('kategori');

        if ($search = $request->string('search')->trim()->value()) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('kode_barang', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        if ($kategoriId = $request->integer('kategori_id')) {
            $query->where('kategori_id', $kategoriId);
        }

        if ($request->filled('ketersediaan')) {
            $value = $request->string('ketersediaan')->value();
            if ($value === 'tersedia') {
                $query->where('stok', '>', 0)->where('status', \App\Enums\StatusBarang::Tersedia);
            } elseif ($value === 'habis') {
                $query->where(function ($q) {
                    $q->where('stok', '<=', 0)
                        ->orWhere('status', '!=', \App\Enums\StatusBarang::Tersedia);
                });
            }
        }

        $barangs = $query->latest()->paginate(12)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('barang.index', compact('barangs', 'kategoris'));
    }

    public function create(): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('barang.create', compact('kategoris'));
    }

    /**
     * Simpan barang baru (pakai StoreBarangRequest).
     */
    public function store(StoreBarangRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('barang', 'public');
        }

        Barang::create($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang): View
    {
        $barang->load('kategori');

        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('barang.edit', compact('barang', 'kategoris'));
    }

    /**
     * Update barang (pakai UpdateBarangRequest).
     */
    public function update(UpdateBarangRequest $request, Barang $barang): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $validated['foto'] = $request->file('foto')->store('barang', 'public');
        }

        $barang->update($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang): RedirectResponse
    {
        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
