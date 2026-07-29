<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi ketika Guru/Admin melakukan Approve Peminjaman.
 * Catatan admin opsional.
 */
class ApprovePeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isGuru() || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'catatan_admin' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'catatan_admin' => 'Catatan Persetujuan',
        ];
    }
}
