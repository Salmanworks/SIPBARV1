<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Models\GuruProfile;
use App\Models\SiswaProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login terpadu untuk semua role.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login berdasarkan role.
     * - Admin: login via email langsung di tabel users.
     * - Guru: lookup NIP di tabel guru_profiles → ambil user terkait.
     * - Siswa: lookup NIS di tabel siswa_profiles → ambil user terkait.
     */
    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|string|in:admin,guru,siswa',
            'identifier' => 'required|string', // email, NIP, atau NIS tergantung role
            'password' => 'required|string',
        ]);

        $role = $request->input('role');
        $identifier = $request->input('identifier');
        $password = $request->input('password');

        // Cari user berdasarkan role dan identifier yang sesuai
        $user = $this->resolveUser($role, $identifier);

        // Verifikasi user ditemukan dan password cocok
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            // Redirect ke dashboard sesuai role
            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'guru' => redirect()->route('dashboard'),
                'siswa' => redirect()->route('dashboard'),
            };
        }

        return back()->withErrors([
            'identifier' => 'Kredensial tidak cocok atau akun tidak aktif.',
        ])->withInput($request->only('role', 'identifier'));
    }

    /**
     * Cari user berdasarkan role dan identifier.
     * Admin dicari via email, Guru via NIP di guru_profiles, Siswa via NIS di siswa_profiles.
     */
    private function resolveUser(string $role, string $identifier): ?User
    {
        return match ($role) {
            'admin' => User::where('email', $identifier)
                ->where('role', UserRole::Admin)
                ->first(),

            'guru' => GuruProfile::where('nip', $identifier)
                ->first()
                ?->user()
                ->where('role', UserRole::Guru)
                ->first(),

            'siswa' => SiswaProfile::where('nis', $identifier)
                ->first()
                ?->user()
                ->where('role', UserRole::Siswa)
                ->first(),

            default => null,
        };
    }

    /**
     * Logout pengguna dan hapus sesi.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
