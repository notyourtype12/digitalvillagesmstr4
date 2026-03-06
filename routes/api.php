<?php

use App\Http\Controllers\API\ApiRegisController;
use App\Http\Controllers\API\ApiLoginController;
use App\Http\Controllers\API\status_diajukan_controller;
use App\Http\Controllers\API\status_selesai_controller;
use App\Http\Controllers\API\Getprofil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\status_ditolak_controller;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\API\BeritaApiController;
use App\Http\Controllers\API\EditProfile;
use App\Http\Controllers\API\MasterPengaduanController;
use App\Http\Controllers\API\PengajuanController;
use App\Http\Controllers\API\NotifikasiController;
use App\Models\MasterPengaduan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Testing\Fakes\PendingMailFake;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//biar aman
Route::middleware('api')->group(function(){
    Route::post('/register', [ApiRegisController::class, 'register']);
    Route::post('/login', [ApiRegisController::class, 'login']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('verify-otp', [ResetPasswordController::class, 'verify'])->name('password.otp');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');

    Route::get('/statusdiajukan', [status_diajukan_controller::class, 'index']);
    Route::get('/statusditolak', [status_ditolak_controller::class, 'index']);
    Route::get('/statusselesai', [status_selesai_controller::class, 'index']);
    Route::delete('/suratdelete/{id}', [status_diajukan_controller::class, 'destroy']);
    
    Route::get('/notifikasi', [NotifikasiController::class, 'index']);
    Route::get('/notifikasi/{id}', [NotifikasiController::class, 'show']);
    

    Route::get('/getprofil', [Getprofil::class, 'index']);
    Route::post('/update-foto', [EditProfile::class, 'updateFoto']);
    Route::post('/update-profil', [EditProfile::class, 'updateEmailNoHp']);
    Route::get('/getdata', [Getprofil::class, 'getByNik']);

    Route::post('/pengajuan', [PengajuanController::class, 'store']);
    Route::post('/pengaduan', [MasterPengaduanController::class, 'store']);
   
    Route::get('/berita', [BeritaApiController::class, 'index']);       // untuk daftar semua berita
    Route::get('/berita/{id}', [BeritaApiController::class, 'show']);
});

Route::middleware('auth:sanctum')->post('/logout', [ApiRegisController::class, 'logout']);

