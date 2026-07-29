<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Bisnis logic untuk Import Guru via CSV.
 * 1 baris CSV = 1 User (role=GURU, no_induk=NIP, first_login=true) + 1 row di tabel gurus.
 * Jika NIP sudah ada di tabel users.no_induk, maka UPDATE record (bukan ditambah duplikat).
 */
class GuruImportService
{
    /**
     * Header yang diterima (case-insensitive, delimiter auto).
     */
    public const TEMPLATE_HEADERS = [
        'nip',
        'nama_lengkap',
        'email',
        'jabatan',
        'no_hp',
        'password',
    ];

    /**
     * @return array{success:int, updated:int, skipped:int, errors:list<string>}
     */
    public function import(array $rows): array
    {
        $errors = [];
        $success = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($rows as $lineNum => $row) {
            $lineNo = $lineNum + 2; // +1 karena index 0, +1 karena baris 1 adalah header

            try {
                $normalized = [
                    'nip' => CsvImporterService::pick($row, ['nip', 'nik', 'id_guru', 'nomor_induk_pegawai', 'nomor_induk']) ?? '',
                    'nama_lengkap' => CsvImporterService::pick($row, ['nama_lengkap', 'nama', 'full_name', 'nama_guru']) ?? '',
                    'email' => CsvImporterService::pick($row, ['email', 'email_guru', 'alamat_email']) ?? '',
                    'jabatan' => CsvImporterService::pick($row, ['jabatan', 'posisi', 'position', 'bidang']) ?? '',
                    'no_hp' => CsvImporterService::pick($row, ['no_hp', 'nohp', 'nomor_hp', 'telpon', 'telepon', 'wa', 'whatsapp', 'hp']) ?? '',
                    'password' => CsvImporterService::pick($row, ['password', 'kata_sandi', 'sandi']) ?? '',
                ];

                $validator = Validator::make($normalized, [
                    'nip' => ['required', 'string', 'max:50'],
                    'nama_lengkap' => ['required', 'string', 'max:200'],
                    'email' => ['nullable', 'email', 'max:150'],
                    'jabatan' => ['nullable', 'string', 'max:150'],
                    'no_hp' => ['nullable', 'string', 'max:30'],
                    'password' => ['nullable', 'string', 'min:8', 'max:100'],
                ], [], [
                    'nip' => 'NIP',
                    'nama_lengkap' => 'Nama Lengkap',
                    'email' => 'Email',
                    'jabatan' => 'Jabatan',
                    'no_hp' => 'No. HP',
                    'password' => 'Password',
                ]);

                if ($validator->fails()) {
                    $msg = "Baris {$lineNo}: ".implode(' | ', $validator->errors()->all());
                    $errors[] = $msg;
                    $skipped++;

                    continue;
                }

                $validated = $validator->validated();

                DB::transaction(function () use ($validated, &$success, &$updated) {
                    // Upsert User berdasarkan no_induk (NIP) + role
                    /** @var User|null $existingUser */
                    $existingUser = User::withTrashed()
                        ->where('role', UserRole::Guru)
                        ->where('no_induk', $validated['nip'])
                        ->first();

                    $userData = [
                        'name' => $validated['nama_lengkap'],
                        'email' => $validated['email'] ?? "guru_{$validated['nip']}@sipbar.sch.id",
                        'role' => UserRole::Guru,
                        'no_induk' => $validated['nip'],
                        'first_login' => true,
                    ];

                    if ($existingUser !== null) {
                        $wasDeleted = $existingUser->trashed();
                        if ($wasDeleted) {
                            $existingUser->restore();
                        }
                        // Password diupdate HANYA jika diisi di CSV
                        if (! empty($validated['password'])) {
                            $userData['password'] = Hash::make($validated['password']);
                            $userData['first_login'] = true;
                        }
                        $existingUser->update($userData);
                        $user = $existingUser;
                        $updated++;
                    } else {
                        $userData['password'] = ! empty($validated['password'])
                            ? Hash::make($validated['password'])
                            : Hash::make($validated['nip']);
                        $user = User::create($userData);
                        $success++;
                    }

                    // Upsert tabel identitas Guru berdasarkan user_id
                    /** @var Guru|null $existingGuru */
                    $existingGuru = Guru::withTrashed()->where('user_id', $user->id)->first();

                    $guruData = [
                        'user_id' => $user->id,
                        'nip' => $validated['nip'],
                        'nama_lengkap' => $validated['nama_lengkap'],
                        'jabatan' => $validated['jabatan'] ?? null,
                        'no_hp' => $validated['no_hp'] ?? null,
                    ];

                    if ($existingGuru !== null) {
                        if ($existingGuru->trashed()) {
                            $existingGuru->restore();
                        }
                        $existingGuru->update($guruData);
                    } else {
                        Guru::create($guruData);
                    }
                });
            } catch (\Throwable $e) {
                $errors[] = "Baris {$lineNo}: [Database] ".$e->getMessage();
                $skipped++;
            }
        }

        if (count($errors) > 0 && $success + $updated === 0) {
            throw ValidationException::withMessages([
                'file' => $errors,
            ]);
        }

        return [
            'success' => $success,
            'updated' => $updated,
            'skipped' => $skipped,
            'errors' => $errors,
        ];
    }
}
