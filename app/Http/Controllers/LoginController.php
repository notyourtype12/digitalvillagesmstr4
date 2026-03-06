<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Untuk hashing
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\master_akun;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

 public function login(Request $request)
{
    $request->validate([
        'nik' => 'required|string|size:16',
        'password' => 'required|string',
    ]);

    $user = master_akun::where('nik', $request->nik)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);

        $penduduk = DB::table('master_penduduks')->where('nik', $user->nik)->first();
        $nama = $penduduk ? $penduduk->nama_lengkap : $user->nik;
        session(['nama' => $nama]);

        // 🔀 Redirect berdasarkan level akun
        switch ($user->level) {
            case 1:
                return redirect()->route('dashboard')->with('success', 'Login sebagai Admin');
            case 2:
                return redirect()->route('rw.dashboard')->with('success', 'Login sebagai RW');
            case 3:
                return redirect()->route('dashboard.rt')->with('success', 'Login sebagai RT');
            default:
                Auth::logout();
                return redirect()->route('login.index')->with('error', 'Level tidak dikenali');
        }

    } else {
        return back()->with('error', 'NIK atau Password salah');
    }
}
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.index')->with('success', 'Berhasil logout!');
    }

    public function getNama()
{
    if (Auth::check()) {
        $user = Auth::user();

        $nama = optional($user->penduduk)->nama_lengkap;

        return $nama ?? $user->nik;
    }

    return null; // Kalau belum login
}

}