<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Guru;
use App\Models\Siswa;
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
                    ->orWhere('no_induk', 'like', "%{$search}%");
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
     * Sinkronisasi data ke tabel gurus / siswas sesuai role user.
     * - role=guru  → buat/update di tabel gurus
     * - role=siswa → buat/update di tabel siswas
     * - role=admin → hapus dari kedua tabel jika ada
     */
    private function syncIdentityTable(User $user, array $data): void
    {
        $nama   = $data['name'] ?? $user->name;
        $noHp   = $user->no_hp ?? null;
        $noInduk = $user->no_induk ?? null;

        if ($user->isGuru()) {
            // Hapus dari siswas jika ada
            Siswa::where('user_id', $user->id)->delete();

            Guru::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip'          => $noInduk,
                    'nama_lengkap' => $nama,
                    'no_hp'        => $noHp,
                ]
            );
        } elseif ($user->isSiswa()) {
            // Hapus dari gurus jika ada
            Guru::where('user_id', $user->id)->delete();

            Siswa::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nis'          => $noInduk,
                    'nama_lengkap' => $nama,
                    'no_hp'        => $noHp,
                ]
            );
        } else {
            // Admin → bersihkan dari kedua tabel
            Guru::where('user_id', $user->id)->delete();
            Siswa::where('user_id', $user->id)->delete();
        }
    }
}
