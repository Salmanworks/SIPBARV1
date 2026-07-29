<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validasi untuk form edit kategori (Admin).
 * - nama_kategori unique kecuali record yang sedang diedit.
 */
class UpdateKategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $kategoriId = $this->route('kategori')?->id ?? $this->route('kategori');

        return [
            'nama_kategori' => ['required', 'string', 'max:255', Rule::unique('kategoris', 'nama_kategori')->ignore($kategoriId)],
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
