<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'keperluan' => 'required|string|min:10|max:500',
            'barang' => 'required|array|min:1',
            'barang.*.id' => 'required|exists:barangs,id',
            'barang.*.jumlah' => 'required|integer|min:1|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam harus hari ini atau tanggal yang akan datang',
            'tanggal_kembali_rencana.after' => 'Tanggal kembali rencana harus setelah tanggal pinjam',
            'keperluan.min' => 'Keperluan minimal 10 karakter',
            'keperluan.max' => 'Keperluan maksimal 500 karakter',
            'barang.required' => 'Pilih minimal 1 barang',
            'barang.*.jumlah.max' => 'Maksimal 10 barang per jenis',
        ];
    }
}
