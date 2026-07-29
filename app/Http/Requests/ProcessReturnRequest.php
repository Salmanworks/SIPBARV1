<?php

namespace App\Http\Requests;

use App\Enums\KondisiBarang;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validasi ketika Guru memproses Pengembalian Barang.
 * Kondisi setiap item detail wajib diisi (Baik / Rusak).
 */
class ProcessReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isGuru() || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'kondisi'     => ['required', 'array', 'min:1'],
            'kondisi.*'   => ['required', Rule::enum(KondisiBarang::class)],
        ];
    }

    public function attributes(): array
    {
        return [
            'kondisi'   => 'Kondisi Barang',
            'kondisi.*' => 'Kondisi Item',
        ];
    }

    public function messages(): array
    {
        return [
            'kondisi.required' => 'Pilih kondisi untuk setiap barang yang dikembalikan.',
            'kondisi.min'      => 'Minimal 1 (satu) kondisi barang harus dipilih.',
        ];
    }
}
