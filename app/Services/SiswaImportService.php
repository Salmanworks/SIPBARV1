<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Bisnis logic untuk Import Siswa via CSV.
 * 1 baris CSV = 1 User (role=SISWA) + SiswaProfile (nis) + 1 row di tabel siswas.
 * Jika NIS sudah ada di tabel siswa_profiles, maka UPDATE record (bukan ditambah duplikat).
 */
class SiswaImportService
{
    public const TEMPLATE_HEADERS = [
        'nis',
        'nama_lengkap',
        'kelas',
        'jurusan',
        'email',
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
            $lineNo = $lineNum + 2;

            try {
                $normalized = [
                    'nis' => CsvImporterService::pick($row, ['nis', 'no_induk_siswa', 'nomor_induk_siswa', 'nik_siswa', 'id_siswa']) ?? '',
                    'nama_lengkap' => CsvImporterService::pick($row, ['nama_lengkap', 'nama', 'full_name', 'nama_siswa']) ?? '',
                    'kelas' => CsvImporterService::pick($row, ['kelas', 'tingkat', 'ruang', 'rombel', 'class']) ?? '',
                    'jurusan' => CsvImporterService::pick($row, ['jurusan', 'program_keahlian', 'keahlian', 'major', 'jurusan_siswa']) ?? '',
                    'email' => CsvImporterService::pick($row, ['email', 'email_siswa', 'alamat_email']) ?? '',
                    'no_hp' => CsvImporterService::pick($row, ['no_hp', 'nohp', 'nomor_hp', 'telpon', 'telepon', 'wa', 'whatsapp', 'hp']) ?? '',
                    'password' => CsvImporterService::pick($row, ['password', 'kata_sandi', 'sandi']) ?? '',
                ];

                $validator = Validator::make($normalized, [
                    'nis' => ['required', 'string', 'max:50'],
                    'nama_lengkap' => ['required', 'string', 'max:200'],
                    'kelas' => ['nullable', 'string', 'max:50'],
                    'jurusan' => ['nullable', 'string', 'max:100'],
                    'email' => ['nullable', 'email', 'max:150'],
                    'no_hp' => ['nullable', 'string', 'max:30'],
                    'password' => ['nullable', 'string', 'min:8', 'max:100'],
                ], [], [
                    'nis' => 'NIS',
                    'nama_lengkap' => 'Nama Lengkap',
                    'kelas' => 'Kelas',
                    'jurusan' => 'Jurusan',
                    'email' => 'Email',
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
                    /** @var \App\Models\SiswaProfile|null $existingProfile */
                    $existingProfile = \App\Models\SiswaProfile::where('nis', $validated['nis'])->first();
                    $existingUser = $existingProfile?->user;
                    if ($existingUser === null) {
                        $existingUser = User::withTrashed()
                            ->where('role', UserRole::Siswa)
                            ->where('email', $validated['email'] ?? "siswa_{$validated['nis']}@sipbar.sch.id")
                            ->first();
                    }

                    $userData = [
                        'name' => $validated['nama_lengkap'],
                        'email' => $validated['email'] ?? "siswa_{$validated['nis']}@sipbar.sch.id",
                        'role' => UserRole::Siswa,
                        'first_login' => true,
                    ];

                    if ($existingUser !== null) {
                        $wasDeleted = $existingUser->trashed();
                        if ($wasDeleted) {
                            $existingUser->restore();
                        }
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
                            : Hash::make($validated['nis']);
                        $user = User::create($userData);
                        $success++;
                    }

                    \App\Models\SiswaProfile::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'nis' => $validated['nis'],
                            'kelas' => $validated['kelas'] ?? null,
                            'jurusan' => $validated['jurusan'] ?? null,
                        ]
                    );

                    /** @var Siswa|null $existingSiswa */
                    $existingSiswa = Siswa::withTrashed()->where('user_id', $user->id)->first();

                    $siswaData = [
                        'user_id' => $user->id,
                        'nis' => $validated['nis'],
                        'nama_lengkap' => $validated['nama_lengkap'],
                        'kelas' => $validated['kelas'] ?? null,
                        'jurusan' => $validated['jurusan'] ?? null,
                        'no_hp' => $validated['no_hp'] ?? null,
                    ];

                    if ($existingSiswa !== null) {
                        if ($existingSiswa->trashed()) {
                            $existingSiswa->restore();
                        }
                        $existingSiswa->update($siswaData);
                    } else {
                        Siswa::create($siswaData);
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
