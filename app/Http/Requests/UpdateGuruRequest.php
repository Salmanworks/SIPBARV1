<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validasi untuk form edit Guru (Admin).
 * - NIP unique kecuali record yang diedit
 * - Password nullable (jika kosong, tidak diganti)
 */
class UpdateGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $guru = $this->route('guru');
        $guruId = $guru?->id ?? $this->route('guru');
        $userId = $guru?->user_id;

        return [
            'nip'          => [
                'required', 'string', 'max:30',
                Rule::unique('gurus', 'nip')->ignore($guruId),
                Rule::unique('users', 'no_induk')->ignore($userId),
            ],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password'     => ['nullable', 'string', 'min:8', 'confirmed'],
            'jabatan'      => ['nullable', 'string', 'max:100'],
            'no_hp'        => ['nullable', 'string', 'max:20'],
            'foto'         => ['nullable', 'image', 'max:2048'],
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
