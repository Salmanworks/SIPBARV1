<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): RedirectResponse|View
    {
        $user = auth()->user();

        return match (true) {
            $user->isAdmin() => redirect()->route('admin.dashboard'),
            $user->isGuru() => redirect()->route('guru.dashboard'),
            default => redirect()->route('peminjam.dashboard'),
        };
    }
}
