<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class FirstLoginMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->first_login) {
            $allowedRoutes = ['profile.edit', 'settings', 'logout'];
            $isAllowed = collect($allowedRoutes)->contains(fn ($r) => $request->routeIs($r));

            if (! $isAllowed && Route::has('profile.edit')) {
                return redirect()->route('profile.edit')
                    ->with('info', 'Anda harus melengkapi data akun pada login pertama.');
            }
        }

        return $next($request);
    }
}
