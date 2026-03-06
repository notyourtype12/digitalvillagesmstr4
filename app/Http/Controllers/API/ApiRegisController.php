<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\master_akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class  ApiRegisController extends Controller
{
    public function register(Request $request)
{
    $nik = $request->nik;

    // 1. Cek apakah NIK ada di master_penduduks
    $penduduk = DB::table('master_penduduks')->where('nik', $nik)->first();
    if (!$penduduk) {
        return response()->json([
            'status' => 'error',
            'message' => 'NIK tidak ditemukan dalam data penduduk.',
        ], 404);
    }

    // 2. Cek apakah NIK sudah ada di master_akun
    $existingAkun = master_akun::where('nik', $nik)->first();
    if ($existingAkun) {
        return response()->json([
            'status' => 'error',
            'message' => 'NIK sudah diaktivasi, silahkan login.',
        ], 409);
    }

    // 3. Validasi input termasuk email unik dan password kuat
    $validator = Validator::make($request->all(), [
        'nik' => 'required',
        'email' => 'required|email|unique:master_akun,email',
        'no_hp' => 'required|min:10',
        'password' => [
            'required',
            'string',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',
        ],
    ], [
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan, silakan gunakan email lain.',
        'no_hp.min' => 'Nomor HP minimal harus terdiri dari 10 digit.',
        'password.regex' => 'Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validasi gagal.',
            'errors' => $validator->errors(),
        ], 422);
    }

    // 4. Simpan akun
    try {
        $user = master_akun::create([
            'nik' => $nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'level' => 4,
            'id_penduduk' => $penduduk->id_penduduk ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Akun berhasil diaktivasi.',
            'master_akun' => $user,
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal mengaktivasi akun, coba lagi.',
            'error_detail' => $e->getMessage()
        ], 500);
    }
}

    

    public function login(Request $request)
{
    // Cek apakah user ditemukan
    $user = master_akun::where('nik', $request->nik)->first();

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'NIK tidak terdaftar, silakan melakukan aktivasi akun terlebih dahulu.'
        ], 404); // Akun tidak ditemukan
    }

    // Cek apakah password cocok
    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Password salah.'
        ], 401); // Password salah
    }

    // Cek apakah akun sudah diaktivasi (misalnya dengan mengecek no_hp)
    if (empty($user->no_hp)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Akun belum diaktivasi. Silakan aktivasi akun terlebih dahulu.'
        ], 403); // Akun belum diaktivasi
    }

    // Jika semua validasi lolos, buat token dan ambil data penduduk
    $token = $user->createToken('personal access token')->plainTextToken;

    // Ambil data penduduk manual dari tabel master_penduduks
    $penduduk = DB::table('master_penduduks')->where('nik', $user->nik)->first();
    $nama = 'Pengguna'; // Default aman
    if ($penduduk && !empty($penduduk->nama_lengkap)) {
        $nama = $penduduk->nama_lengkap;
    }

    // Siapkan response
    $response = [
        'status' => 'success',
        'message' => 'Selamat Datang',
        'data' => [
            'master_akun' => [
                'nik' => $user->nik,
                'nama' => $nama,
                'no_hp' => $user->no_hp,
            ],
            'token' => $token,
        ]
    ];

    return response()->json($response, 200); // Login sukses
}

    public function logout(Request $request)
    {
        // Hapus token saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil logout.'
        ], 200);
    }

}