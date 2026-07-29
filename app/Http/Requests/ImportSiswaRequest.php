<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class ImportSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\User $user */
        $user = $this->user();

        return $user !== null && $user->role === UserRole::Admin;
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'mimes:csv,txt,tsv',
                'max:5120',
            ],
        ];
    }

    /**
     * @return array<string,string>
     */
    public function messages(): array
    {
        return [
            'file.required' => 'File CSV wajib dipilih.',
            'file.file' => 'Input harus berupa file yang valid.',
            'file.mimes' => 'Format file harus CSV, TSV, atau TXT (delimiter koma/titik koma/tab).',
            'file.max' => 'Ukuran file maksimal 5 MB.',
        ];
    }

    /**
     * @return array<string,string>
     */
    public function attributes(): array
    {
        return [
            'file' => 'File CSV Import Siswa',
        ];
    }
}
