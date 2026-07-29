<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validasi untuk form edit User (Admin).
 * - Password nullable (jika tidak diisi, tidak diubah)
 * - Email unique kecuali user yang sedang diedit
 */
class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? $this->route('user');

        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password'   => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'       => ['required', Rule::enum(UserRole::class)],
            'identitas'  => [
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
            'name'      => 'Nama Lengkap',
            'email'     => 'Email',
            'password'  => 'Password',
            'role'      => 'Role / Jabatan',
            'identitas' => 'Nomor Identitas (NIP / NIS / ID Admin)',
        ];
    }

    public function messages(): array
    {
        return [
            'identitas.required_if' => ':attribute wajib diisi untuk role Guru dan Siswa.',
        ];
    }
}
