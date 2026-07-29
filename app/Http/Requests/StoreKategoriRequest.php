<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi untuk form tambah kategori (Admin).
 */
class StoreKategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:kategoris,nama_kategori'],
            'deskripsi'     => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_kategori' => 'Nama Kategori',
            'deskripsi'     => 'Deskripsi Kategori',
        ];
    }
}
