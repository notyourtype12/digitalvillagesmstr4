<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\master_akun; // Ganti jika pakai model lain

class ResetPasswordController extends Controller
{
//     public function verify(Request $request)
// {
//     $request->validate([
//         'otp' => 'required',
//         'email' => 'required|email', // Ganti dari email ke akun
//     ]);

//     $resetRecord = DB::table('password_resets')
//         ->where('email', $request->email)
//         ->where('otp', $request->otp)
//         ->first();

//     if (!$resetRecord) {
//         throw ValidationException::withMessages([
//             'otp' => ['OTP tidak valid.'],
//         ]);
//     }

//     if (now()->gt($resetRecord->otp_expires_at)) {
//         throw ValidationException::withMessages([
//             'otp' => ['OTP telah kedaluwarsa.'],
//         ]);
//     }

//     return response()->json([
//         'message' => 'OTP valid.',
//     ], 200);
// }

public function verify(Request $request)
{
    $request->validate([
        'otp' => 'required',
        'email' => 'required|email',
    ]);

    $resetRecord = DB::table('password_resets')
        ->where('email', $request->email)
        ->where('otp', $request->otp)
        ->first();

    if (!$resetRecord) {
        return response()->json([
            'message' => 'OTP tidak valid',
        ], 422); 
    }

    if (now()->gt($resetRecord->otp_expires_at)) {
        return response()->json([
            'message' => 'OTP tidak valid',
        ], 200);
    }

    return response()->json([
        'status' => 200,
        'message' => 'OTP valid.',
    ], 200);
}


public function reset(Request $request)
{
    $request->validate([
        'otp' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $resetRecord = DB::table('password_resets')
        ->where('email', $request->email)
        ->where('otp', $request->otp)
        ->first();

    if (!$resetRecord) {
        throw ValidationException::withMessages([
            'otp' => ['OTP tidak valid.'],
        ]);
    }

    $user = master_akun::where('email', $request->email)->first();

    if (!$user) {
        throw ValidationException::withMessages([
            'email' => ['Email tidak ditemukan.'],
        ]);
    }

    $user->forceFill([
        'password' => Hash::make($request->password),
    ])->save();

    DB::table('password_resets')->where('email', $request->email)->delete();

    return response()->json([
        'status' => 200,
        'message' => 'Password berhasil direset.',
    ], 200);
}

}
