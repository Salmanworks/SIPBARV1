<?php

namespace App\Http\Requests;

use App\Enums\KondisiBarang;
use App\Enums\StatusBarang;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validasi untuk form edit barang (Admin).
 * - kode_barang unique kecuali untuk record yang sedang diedit.
 */
class UpdateBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $barangId = $this->route('barang')?->id ?? $this->route('barang');

        return [
            'kode_barang' => ['required', 'string', 'max:50', Rule::unique('barangs', 'kode_barang')->ignore($barangId)],
            'nama_barang' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'stok'        => ['required', 'integer', 'min:0'],
            'kondisi'     => ['required', Rule::enum(KondisiBarang::class)],
            'status'      => ['required', Rule::enum(StatusBarang::class)],
            'lokasi'      => ['nullable', 'string', 'max:150'],
            'deskripsi'   => ['nullable', 'string'],
            'foto'        => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'kode_barang' => 'Kode Barang',
            'nama_barang' => 'Nama Barang',
            'kategori_id' => 'Kategori',
            'stok'        => 'Jumlah Stok',
            'kondisi'     => 'Kondisi',
            'status'      => 'Status Barang',
            'lokasi'      => 'Lokasi Penyimpanan',
            'deskripsi'   => 'Deskripsi',
            'foto'        => 'Foto Barang',
        ];
    }
}
