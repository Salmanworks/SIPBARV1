<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\AdminProfile;
use App\Models\Guru;
use App\Models\GuruProfile;
use App\Models\Siswa;
use App\Models\SiswaProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($search = $request->string('search')->trim()->value()) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    // Cari identitas di tabel profile masing-masing role
                    ->orWhereHas('siswaProfile', fn ($sub) => $sub->where('nis', 'like', "%{$search}%"))
                    ->orWhereHas('guruProfile', fn ($sub) => $sub->where('nip', 'like', "%{$search}%"))
                    ->orWhereHas('adminProfile', fn ($sub) => $sub->where('id_admin', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->string('role')->value());
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Simpan user baru (pakai StoreUserRequest).
     * Juga otomatis membuatkan record di tabel gurus/siswas sesuai role.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated) {
            $validated['password']          = Hash::make($validated['password']);
            $validated['email_verified_at'] = now();
            $validated['first_login']       = true;

            $user = User::create($validated);

            // Sinkron ke tabel gurus atau siswas sesuai role
            $this->syncIdentityTable($user, $validated);

            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
        });
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update user (pakai UpdateUserRequest).
     * Juga sinkron data ke tabel gurus/siswas jika role berubah.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated, $user) {
            if (empty($validated['password'])) {
                unset($validated['password']);
            } else {
                $validated['password'] = Hash::make($validated['password']);
            }

            $oldRole = $user->role;
            $user->update($validated);

            // Jika role berubah, sinkron ke tabel identity terkait
            if ($oldRole !== $user->role) {
                $this->syncIdentityTable($user, $validated);
            }

            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
        });
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Sinkronisasi data ke tabel gurus / siswas / profile sesuai role user.
     * - role=guru  → buat/update di tabel gurus + guru_profiles
     * - role=siswa → buat/update di tabel siswas + siswa_profiles
     * - role=admin → hapus dari kedua tabel gurus/siswas, buat admin_profiles
     */
    private function syncIdentityTable(User $user, array $data): void
    {
        $nama   = $data['name'] ?? $user->name;
        $noHp   = $user->no_hp ?? null;
        // Ambil identitas dari field 'identitas' di form (jika ada)
        $identitas = $data['identitas'] ?? null;

        if ($user->isGuru()) {
            // Hapus dari siswas jika ada
            Siswa::where('user_id', $user->id)->delete();

            Guru::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip'          => $identitas,
                    'nama_lengkap' => $nama,
                    'no_hp'        => $noHp,
                ]
            );

            // Sinkron profil guru
            if ($identitas) {
                GuruProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    ['nip' => $identitas]
                );
            }
        } elseif ($user->isSiswa()) {
            // Hapus dari gurus jika ada
            Guru::where('user_id', $user->id)->delete();

            Siswa::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nis'          => $identitas,
                    'nama_lengkap' => $nama,
                    'no_hp'        => $noHp,
                ]
            );

            // Sinkron profil siswa
            if ($identitas) {
                SiswaProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    ['nis' => $identitas]
                );
            }
        } else {
            // Admin → bersihkan dari kedua tabel legacy
            Guru::where('user_id', $user->id)->delete();
            Siswa::where('user_id', $user->id)->delete();

            // Sinkron profil admin
            if ($identitas) {
                AdminProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    ['id_admin' => $identitas]
                );
            }
        }
    }
}
