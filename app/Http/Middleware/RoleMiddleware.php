<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            // Jika belum login, redirect ke login
            return redirect()->route('login.index');
        }

        // Cek level user
        if (Auth::user()->level != $role) {
            // Redirect sesuai level user agar tidak looping
            if (Auth::user()->level == 1) {
                return redirect()->route('dashboard'); // admin dashboard
            } elseif (Auth::user()->level == 2) {
                return redirect()->route('rw.dashboard');
            } elseif (Auth::user()->level == 3) {
                return redirect()->route('dashboard.rt');
            } else {
                // Kalau level tidak dikenali, logout atau ke login
                return redirect()->route('login.index');
            }
        }

        // Jika role cocok, lanjutkan request
        return $next($request);
    }
}