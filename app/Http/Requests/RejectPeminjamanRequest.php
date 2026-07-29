<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi ketika Guru/Admin melakukan Reject Peminjaman.
 * Alasan penolakan WAJIB diisi minimal 5 karakter.
 */
class RejectPeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isGuru() || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'catatan_admin' => ['required', 'string', 'min:5', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'catatan_admin' => 'Alasan Penolakan',
        ];
    }

    public function messages(): array
    {
        return [
            'catatan_admin.required' => 'Alasan penolakan wajib diisi.',
            'catatan_admin.min'      => 'Alasan penolakan minimal 5 karakter.',
        ];
    }
}
