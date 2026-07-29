<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validasi untuk form tambah User (Admin).
 * - Password wajib diisi + confirmed
 * - Email unique
 * - no_induk required khusus untuk Guru dan Siswa
 */
class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'role'      => ['required', Rule::enum(UserRole::class)],
            'no_induk'  => [
                Rule::requiredIf(in_array($this->input('role'), [UserRole::Guru->value, UserRole::Siswa->value], true)),
                'nullable',
                'string',
                'max:50',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'     => 'Nama Lengkap',
            'email'    => 'Email',
            'password' => 'Password',
            'role'     => 'Role / Jabatan',
            'no_induk' => 'Nomor Induk (NIP / NIS)',
        ];
    }

    public function messages(): array
    {
        return [
            'no_induk.required_if' => ':attribute wajib diisi untuk role Guru dan Siswa.',
        ];
    }
}
