<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Validasi email
            $request->validate([
                'email' => ['required', 'email', 'exists:master_akun,email'],
            ]);

           
            $otp = rand(100000, 999999); // 6-digit OTP
            $token = Str::random(60);
            $expiresAt = now()->addMinutes(10);

            
            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                [
                    'otp' => $otp,
                    'token' => $token,
                    'otp_expires_at' => $expiresAt,
                    'created_at' => now(),
                ]
            );

            
            Mail::raw("Kode OTP Anda adalah: $otp. Kode ini berlaku selama 10 menit.", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Kode OTP untuk Reset Password')
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            return response()->json([
                'message' => 'Kode OTP telah dikirim ke email Anda.',
                'status' => 200
            ], 200);

        } catch (ValidationException $e) {
            
            return response()->json([
                'message' => 'Email tidak terdaftar.',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);

        } catch (\Exception $e) {
            
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }
}
