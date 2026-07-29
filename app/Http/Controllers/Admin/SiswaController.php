<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportSiswaRequest;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Siswa;
use App\Models\SiswaProfile;
use App\Models\User;
use App\Enums\UserRole;
use App\Services\CsvImporterService;
use App\Services\SiswaImportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Resource Controller untuk mengelola data Siswa (Admin).
 *
 * Setiap Siswa dihubungkan dengan satu record User (role=siswa).
 * Password user dibuatkan otomatis dari NIS jika tidak diisi manual (first_login=true).
 */
class SiswaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Siswa::with('user');

        if ($search = $request->string('search')->trim()->value()) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('kelas', 'like', "%{$search}%")
                    ->orWhere('jurusan', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($sub) => $sub->where('email', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->string('kelas')->value());
        }

        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->string('jurusan')->value());
        }

        $siswas = $query->latest()->paginate(10)->withQueryString();

        // Daftar kelas & jurusan unik untuk dropdown filter
        $kelasOptions   = Siswa::distinct()->orderBy('kelas')->pluck('kelas')->filter();
        $jurusanOptions = Siswa::distinct()->orderBy('jurusan')->pluck('jurusan')->filter();

        return view('admin.siswa.index', compact('siswas', 'kelasOptions', 'jurusanOptions'));
    }

    public function create(): View
    {
        return view('admin.siswa.create');
    }

    /**
     * Simpan data Siswa BARU + otomatis buat User terkait role=siswa.
     */
    public function store(StoreSiswaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated, $request) {
            // 1) Create User role=siswa terlebih dahulu
            $password = ! empty($validated['password'])
                ? Hash::make($validated['password'])
                : Hash::make($validated['nis']); // Default: NIS sebagai password awal

            // Email siswa boleh kosong — isi dummy jika tidak ada, supaya kolom unique tidak bentrok
            $email = ! empty($validated['email'])
                ? $validated['email']
                : "siswa_{$validated['nis']}@sipbar.sch.id";

            $user = User::create([
                'name'              => $validated['nama_lengkap'],
                'email'             => $email,
                'password'          => $password,
                'role'              => UserRole::Siswa,
                'no_hp'             => $validated['no_hp'] ?? null,
                'email_verified_at' => now(),
                'first_login'       => true, // Paksa ganti password saat login pertama
            ]);

            // Buat profil siswa baru yang menyimpan NIS, kelas, dan jurusan
            SiswaProfile::create([
                'user_id' => $user->id,
                'nis'     => $validated['nis'],
                'kelas'   => $validated['kelas'] ?? null,
                'jurusan' => $validated['jurusan'] ?? null,
            ]);

            // 2) Create record Siswa dengan user_id
            $siswaData = [
                'user_id'      => $user->id,
                'nis'          => $validated['nis'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'kelas'        => $validated['kelas'] ?? null,
                'jurusan'      => $validated['jurusan'] ?? null,
                'no_hp'        => $validated['no_hp'] ?? null,
            ];

            if ($request->hasFile('foto')) {
                $siswaData['foto'] = $request->file('foto')->store('siswa', 'public');
            }

            Siswa::create($siswaData);

            return redirect()
                ->route('admin.siswa.index')
                ->with('success', 'Data Siswa berhasil ditambahkan. Akun login dibuat otomatis (password default: NIS).');
        });
    }

    public function edit(Siswa $siswa): View
    {
        $siswa->load('user');

        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Update data Siswa + User terkait.
     */
    public function update(UpdateSiswaRequest $request, Siswa $siswa): RedirectResponse
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated, $request, $siswa) {
            // 1) Update User terkait
            $email = ! empty($validated['email'])
                ? $validated['email']
                : "siswa_{$validated['nis']}@sipbar.sch.id";

            $userData = [
                'name'     => $validated['nama_lengkap'],
                'email'    => $email,
                'no_hp'    => $validated['no_hp'] ?? null,
            ];

            if (! empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $siswa->user->update($userData);

            // Sinkron profil siswa (NIS, kelas, jurusan)
            SiswaProfile::updateOrCreate(
                ['user_id' => $siswa->user_id],
                [
                    'nis'     => $validated['nis'],
                    'kelas'   => $validated['kelas'] ?? null,
                    'jurusan' => $validated['jurusan'] ?? null,
                ]
            );

            // 2) Update record Siswa
            $siswaData = [
                'nis'          => $validated['nis'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'kelas'        => $validated['kelas'] ?? null,
                'jurusan'      => $validated['jurusan'] ?? null,
                'no_hp'        => $validated['no_hp'] ?? null,
            ];

            if ($request->hasFile('foto')) {
                if ($siswa->foto) {
                    Storage::disk('public')->delete($siswa->foto);
                }
                $siswaData['foto'] = $request->file('foto')->store('siswa', 'public');
            }

            $siswa->update($siswaData);

            return redirect()
                ->route('admin.siswa.index')
                ->with('success', 'Data Siswa berhasil diperbarui.');
        });
    }

    /**
     * Hapus data Siswa (SoftDelete) + User terkait ikut terhapus.
     */
    public function destroy(Siswa $siswa): RedirectResponse
    {
        if ($siswa->user_id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        return DB::transaction(function () use ($siswa) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }

            // Soft delete siswa
            $siswa->delete();

            // Soft delete user terkait
            if ($siswa->user) {
                $siswa->user->delete();
            }

            return redirect()
                ->route('admin.siswa.index')
                ->with('success', 'Data Siswa berhasil dihapus.');
        });
    }

    /**
     * Download template CSV kosong untuk diisi via Excel/Google Sheet.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $filename = 'template_import_siswa_'.date('Ymd').'.csv';
        $headers = SiswaImportService::TEMPLATE_HEADERS;
        $sampleRow = [
            '202401001',
            'Alya Putri Nusantara',
            'X-IPA-1',
            'IPA',
            'alya.putri@contoh.sch.id',
            '081234567891',
            '',
        ];

        return response()->streamDownload(function () use ($headers, $sampleRow) {
            $output = fopen('php://output', 'w');
            if ($output === false) {
                return;
            }
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, $headers);
            fputcsv($output, $sampleRow);
            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Proses upload & import CSV Siswa.
     */
    public function import(ImportSiswaRequest $request, SiswaImportService $service): RedirectResponse
    {
        try {
            $parsed = CsvImporterService::readCsv($request->file('file'));

            $result = $service->import($parsed['rows']);

            $statusMsg = "Import Siswa selesai. Berhasil ditambahkan: <b>{$result['success']}</b> data. Diperbarui: <b>{$result['updated']}</b> data. Dilewati: <b>{$result['skipped']}</b> data.";

            if (count($result['errors']) > 0) {
                $errorMsg = implode('<br>• ', array_slice($result['errors'], 0, 20));
                if (count($result['errors']) > 20) {
                    $errorMsg .= '<br>...dan '.(count($result['errors']) - 20).' error lainnya.';
                }

                return redirect()
                    ->route('admin.siswa.index')
                    ->with('warning', "{$statusMsg}<br><br><b>Catatan validasi baris:</b><br>• {$errorMsg}");
            }

            return redirect()
                ->route('admin.siswa.index')
                ->with('success', $statusMsg);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            throw $ve;
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.siswa.index')
                ->with('error', 'Gagal mengimport Siswa: '.$e->getMessage());
        }
    }
}
