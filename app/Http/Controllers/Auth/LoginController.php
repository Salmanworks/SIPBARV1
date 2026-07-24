<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    /**
     * Show the unified login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request for Admin, Guru, and Siswa.
     */
    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|string|in:admin,guru,siswa',
            'identifier' => 'required|string', // email, NIP, or NIS depending on role
            'password' => 'required|string',
        ]);

        $role = $request->input('role');
        $identifier = $request->input('identifier');
        $password = $request->input('password');

        // Resolve the login column based on role using UserRole enum
        $loginColumn = match ($role) {
            'admin' => UserRole::Admin->loginField(),
            'guru' => UserRole::Guru->loginField(),
            'siswa' => UserRole::Siswa->loginField(),
        };

        $credentials = [
            $loginColumn => $identifier,
            'password' => $password,
            'role' => UserRole::tryFrom($role),
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Redirect to role‑specific dashboard
            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'guru' => redirect()->route('dashboard'), // assuming generic dashboard
                'siswa' => redirect()->route('dashboard'),
            };
        }

        return back()->withErrors([
            'identifier' => 'Kredensial tidak cocok atau akun tidak aktif.',
        ])->withInput($request->only('role', 'identifier'));
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
