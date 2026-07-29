<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validasi untuk form edit Siswa (Admin).
 * - NIS unique kecuali record yang diedit
 * - Password nullable (jika kosong, tidak diganti)
 */
class UpdateSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $siswa = $this->route('siswa');
        $siswaId = $siswa?->id ?? $this->route('siswa');
        $userId = $siswa?->user_id;

        return [
            'nis'          => [
                'required', 'string', 'max:20',
                Rule::unique('siswas', 'nis')->ignore($siswaId),
                Rule::unique('siswa_profiles', 'nis')->ignore($userId, 'user_id'),
            ],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email'        => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password'     => ['nullable', 'string', 'min:8', 'confirmed'],
            'kelas'        => ['nullable', 'string', 'max:10'],
            'jurusan'      => ['nullable', 'string', 'max:100'],
            'no_hp'        => ['nullable', 'string', 'max:20'],
            'foto'         => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nis'          => 'Nomor Induk Siswa (NIS)',
            'nama_lengkap' => 'Nama Lengkap Siswa',
            'email'        => 'Email',
            'password'     => 'Password',
            'kelas'        => 'Kelas',
            'jurusan'      => 'Jurusan',
            'no_hp'        => 'Nomor HP',
            'foto'         => 'Foto Siswa',
        ];
    }
}
