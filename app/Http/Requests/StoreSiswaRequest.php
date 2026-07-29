<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi untuk form tambah Siswa (Admin).
 * - Otomatis create user terkait role=siswa
 */
class StoreSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nis'          => ['required', 'string', 'max:20', 'unique:siswas,nis', 'unique:siswa_profiles,nis'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email'        => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
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
