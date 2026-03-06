<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        Log::info('RedirectIfAuthenticated is active');

        $guard = $guards[0] ?? null;

        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();
            $routeName = optional($request->route())->getName();

            Log::info('Current route: ' . $routeName);
            Log::info('User level: ' . $user->level);

            // Redirect hanya jika sedang di halaman login (GET/POST)
            if ($request->routeIs('login.*')) {
                switch ($user->level) {
                    case 1:
            Log::info('RedirectIfAuthenticated: admin/dashboard');
                        return redirect()->route('dashboard');
                    case 2:
            Log::info('RedirectIfAuthenticated: rw/dashboard-rw');
                        return redirect()->route('rw.dashboard');
                    case 3:
            Log::info('RedirectIfAuthenticated: rt/dashboard-rt');
                        return redirect()->route('dashboard.rt');
                    default:
                        return redirect('/login');
                }
            }
        }

        return $next($request);
    }
}