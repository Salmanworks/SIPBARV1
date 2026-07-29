<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi ketika User mengganti Password di halaman Settings / First Login.
 */
class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'current_password'      => ['required', 'string', 'current_password'],
            'password'              => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ];
    }

    public function attributes(): array
    {
        return [
            'current_password'      => 'Password Lama',
            'password'              => 'Password Baru',
            'password_confirmation' => 'Konfirmasi Password Baru',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.current_password' => 'Password lama yang Anda masukkan tidak sesuai.',
            'password.different'                => 'Password baru harus berbeda dengan password lama.',
        ];
    }
}
