<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportGuruRequest;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Models\Guru;
use App\Models\GuruProfile;
use App\Models\User;
use App\Enums\UserRole;
use App\Services\CsvImporterService;
use App\Services\GuruImportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Resource Controller untuk mengelola data Guru (Admin).
 *
 * Setiap Guru dihubungkan dengan satu record User (role=guru).
 * Password user dibuatkan otomatis dari NIP jika tidak diisi manual (first_login=true).
 */
class GuruController extends Controller
{
    public function index(Request $request): View
    {
        $query = Guru::with('user');

        if ($search = $request->string('search')->trim()->value()) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($sub) => $sub->where('email', 'like', "%{$search}%"));
            });
        }

        $gurus = $query->latest()->paginate(10)->withQueryString();

        return view('admin.guru.index', compact('gurus'));
    }

    public function create(): View
    {
        return view('admin.guru.create');
    }

    /**
     * Simpan data Guru BARU + otomatis buat User terkait role=guru.
     */
    public function store(StoreGuruRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated, $request) {
            // 1) Create User role=guru terlebih dahulu
            $password = ! empty($validated['password'])
                ? Hash::make($validated['password'])
                : Hash::make($validated['nip']); // Default: NIP sebagai password awal

            $user = User::create([
                'name'              => $validated['nama_lengkap'],
                'email'             => $validated['email'],
                'password'          => $password,
                'role'              => UserRole::Guru,
                'no_hp'             => $validated['no_hp'] ?? null,
                'email_verified_at' => now(),
                'first_login'       => true, // Paksa ganti password saat login pertama
            ]);

            // Buat profil guru baru yang menyimpan NIP dan mata pelajaran
            GuruProfile::create([
                'user_id' => $user->id,
                'nip'     => $validated['nip'],
                'mapel'   => $validated['jabatan'] ?? null,
            ]);

            // 2) Create record Guru dengan user_id
            $guruData = [
                'user_id'      => $user->id,
                'nip'          => $validated['nip'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'jabatan'      => $validated['jabatan'] ?? null,
                'no_hp'        => $validated['no_hp'] ?? null,
            ];

            if ($request->hasFile('foto')) {
                $guruData['foto'] = $request->file('foto')->store('guru', 'public');
            }

            Guru::create($guruData);

            return redirect()
                ->route('admin.guru.index')
                ->with('success', 'Data Guru berhasil ditambahkan. Akun login dibuat otomatis (password default: NIP).');
        });
    }

    public function edit(Guru $guru): View
    {
        $guru->load('user');

        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update data Guru + User terkait.
     */
    public function update(UpdateGuruRequest $request, Guru $guru): RedirectResponse
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated, $request, $guru) {
            // 1) Update User terkait
            $userData = [
                'name'     => $validated['nama_lengkap'],
                'email'    => $validated['email'],
                'no_hp'    => $validated['no_hp'] ?? null,
            ];

            if (! empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $guru->user->update($userData);

            // Sinkron profil guru (NIP dan mapel)
            GuruProfile::updateOrCreate(
                ['user_id' => $guru->user_id],
                [
                    'nip'   => $validated['nip'],
                    'mapel' => $validated['jabatan'] ?? null,
                ]
            );

            // 2) Update record Guru
            $guruData = [
                'nip'          => $validated['nip'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'jabatan'      => $validated['jabatan'] ?? null,
                'no_hp'        => $validated['no_hp'] ?? null,
            ];

            if ($request->hasFile('foto')) {
                if ($guru->foto) {
                    Storage::disk('public')->delete($guru->foto);
                }
                $guruData['foto'] = $request->file('foto')->store('guru', 'public');
            }

            $guru->update($guruData);

            return redirect()
                ->route('admin.guru.index')
                ->with('success', 'Data Guru berhasil diperbarui.');
        });
    }

    /**
     * Hapus data Guru (SoftDelete) + User terkait ikut terhapus.
     */
    public function destroy(Guru $guru): RedirectResponse
    {
        if ($guru->user_id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        return DB::transaction(function () use ($guru) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }

            // Soft delete guru terlebih dahulu
            $guru->delete();

            // Soft delete user terkait (opsional: tetap ada user atau ikut dihapus? ikut spesifikasi)
            // Di sini kita ikut hapus user karena Guru tidak bisa login tanpa relasi.
            if ($guru->user) {
                $guru->user->delete();
            }

            return redirect()
                ->route('admin.guru.index')
                ->with('success', 'Data Guru berhasil dihapus.');
        });
    }

    /**
     * Download template CSV kosong untuk diisi via Excel/Google Sheet.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $filename = 'template_import_guru_'.date('Ymd').'.csv';
        $headers = GuruImportService::TEMPLATE_HEADERS;
        $sampleRow = [
            '198501012010011001',
            'Drs. Hadi Sutanto, M.Pd.',
            'hadi.sutanto@sekolah.sch.id',
            'Guru Matematika',
            '081234567890',
            '',
        ];

        return response()->streamDownload(function () use ($headers, $sampleRow) {
            $output = fopen('php://output', 'w');
            if ($output === false) {
                return;
            }
            // UTF-8 BOM agar Excel mengenali encoding dengan benar
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
     * Proses upload & import CSV Guru.
     */
    public function import(ImportGuruRequest $request, GuruImportService $service): RedirectResponse
    {
        try {
            $parsed = CsvImporterService::readCsv($request->file('file'));

            $result = $service->import($parsed['rows']);

            $statusMsg = "Import Guru selesai. Berhasil ditambahkan: <b>{$result['success']}</b> data. Diperbarui: <b>{$result['updated']}</b> data. Dilewati: <b>{$result['skipped']}</b> data.";

            if (count($result['errors']) > 0) {
                $errorMsg = implode('<br>• ', array_slice($result['errors'], 0, 20));
                if (count($result['errors']) > 20) {
                    $errorMsg .= '<br>...dan '.(count($result['errors']) - 20).' error lainnya.';
                }

                return redirect()
                    ->route('admin.guru.index')
                    ->with('warning', "{$statusMsg}<br><br><b>Catatan validasi baris:</b><br>• {$errorMsg}");
            }

            return redirect()
                ->route('admin.guru.index')
                ->with('success', $statusMsg);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            throw $ve;
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.guru.index')
                ->with('error', 'Gagal mengimport Guru: '.$e->getMessage());
        }
    }
}
