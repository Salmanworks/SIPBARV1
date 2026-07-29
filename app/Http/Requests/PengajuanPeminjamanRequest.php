<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi ketika Siswa mengajukan Peminjaman barang.
 */
class PengajuanPeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isSiswa() || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'barang_id'              => ['required', 'array', 'min:1'],
            'barang_id.*'            => ['required', 'exists:barangs,id'],
            'jumlah'                 => ['required', 'array'],
            'jumlah.*'               => ['required', 'integer', 'min:1'],
            'tanggal_pinjam'         => ['required', 'date', 'after_or_equal:today'],
            'tanggal_kembali_rencana' => ['required', 'date', 'after:tanggal_pinjam'],
            'keperluan'              => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'barang_id'              => 'Pilihan Barang',
            'barang_id.*'            => 'Barang',
            'jumlah'                 => 'Jumlah per Barang',
            'jumlah.*'               => 'Jumlah',
            'tanggal_pinjam'         => 'Tanggal Pinjam',
            'tanggal_kembali_rencana' => 'Tanggal Rencana Kembali',
            'keperluan'              => 'Keperluan Peminjaman',
        ];
    }

    public function messages(): array
    {
        return [
            'barang_id.min'                  => 'Pilih minimal 1 (satu) barang yang akan dipinjam.',
            'tanggal_pinjam.after_or_equal'  => 'Tanggal pinjam minimal hari ini atau setelahnya.',
            'tanggal_kembali_rencana.after'  => 'Tanggal kembali harus setelah tanggal pinjam.',
            'keperluan.min'                  => 'Keperluan minimal 10 karakter.',
        ];
    }
}
