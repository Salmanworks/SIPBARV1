<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FirstLoginMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user && $user->first_login && ! $request->routeIs('first.password.*', 'logout')) {
            return redirect()->route('first.password.show')
                ->with('info', 'Anda harus mengganti password pada login pertama.');
        }
        return $next($request);
    }
}
