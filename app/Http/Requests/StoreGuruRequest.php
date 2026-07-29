<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi untuk form tambah Guru (Admin).
 * - Otomatis create user terkait role=guru
 */
class StoreGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nip'         => ['required', 'string', 'max:30', 'unique:gurus,nip', 'unique:guru_profiles,nip'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
            'jabatan'     => ['nullable', 'string', 'max:100'],
            'no_hp'       => ['nullable', 'string', 'max:20'],
            'foto'        => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nip'          => 'Nomor Induk Pegawai (NIP)',
            'nama_lengkap' => 'Nama Lengkap Guru',
            'email'        => 'Email',
            'password'     => 'Password',
            'jabatan'      => 'Jabatan',
            'no_hp'        => 'Nomor HP',
            'foto'         => 'Foto Guru',
        ];
    }
}
