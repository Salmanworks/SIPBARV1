<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi scan QR Code dari Peminjaman.
 * Digunakan ketika Guru scan QR Siswa untuk memproses penyerahan/pengembalian.
 */
class ScanQrRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isGuru() || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'qr_payload' => ['required', 'string', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'qr_payload' => 'Hasil Scan QR Code',
        ];
    }
}
