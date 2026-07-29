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
            $allowedRoutes = ['security.edit', 'settings', 'logout'];
            $isAllowed = collect($allowedRoutes)->contains(fn ($r) => $request->routeIs($r));

            if (! $isAllowed && Route::has('security.edit')) {
                return redirect()->route('security.edit')
                    ->with('info', 'Anda harus mengganti password default sebelum melanjutkan.');
            }
        }

        return $next($request);
    }
}
