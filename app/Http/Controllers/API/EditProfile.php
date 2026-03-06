<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\master_akun;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;



class EditProfile extends Controller
{
    public function updateFoto(Request $request)
{
    try {
        // Validasi input
        $request->validate([
            'nik' => 'required|exists:master_akun,nik',
            'foto_profil' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        $file = $request->file('foto_profil');
        if (!$file) {
            return response()->json([
                'status' => 'error',
                'message' => 'File foto_profil tidak ditemukan',
            ], 400);
        }

        $user = master_akun::where('nik', $request->nik)->first();

        // Generate nama file random + ekstensi asli
        $extension = $file->getClientOriginalExtension();
        $randomName = Str::random(40) . '.' . $extension;

        // Simpan file dengan nama baru ke folder public/foto_profil
        $path = $file->storeAs('public/foto_profil', $randomName);

        // Hapus foto lama jika ada
        if ($user->foto_profil && Storage::exists('public/foto_profil/' . $user->foto_profil)) {
            Storage::delete('public/foto_profil/' . $user->foto_profil);
        }

        // Simpan nama file random ke database
        $user->foto_profil = $randomName;
        $user->save();

        return response()->json([
            'status' => 'success',
            'foto_url' => Storage::url('public/foto_profil/' . $randomName),
        ], 200);

    } catch (ValidationException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validasi gagal',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
        ], 500);
    }
}

public function updateEmailNoHp(Request $request)
{
    try {
        // Validasi input: nik wajib, email & no_hp boleh nullable
        $request->validate([
            'nik' => 'required|exists:master_akun,nik',
            'email' => 'nullable|email',
            'no_hp' => 'nullable|string|max:20',
        ]);

        // Cari user berdasarkan nik
        $user = master_akun::where('nik', $request->nik)->first();

        // Variabel untuk menandai perubahan
        $updatedFields = [];

        // Update email jika ada dan berbeda
        if ($request->has('email') && $request->email !== $user->email) {
            $user->email = $request->email;
            $updatedFields[] = 'email';
        }

        // Update no_hp jika ada dan berbeda
        if ($request->has('no_hp') && $request->no_hp !== $user->no_hp) {
            $user->no_hp = $request->no_hp;
            $updatedFields[] = 'no_hp';
        }

        // Jika tidak ada perubahan
        if (empty($updatedFields)) {
            return response()->json([
                'status' => 'info',
                'message' => 'Tidak ada data yang diubah.',
            ], 200);
        }

        // Simpan perubahan
        $user->save();

        // Siapkan pesan sesuai perubahan
        if (count($updatedFields) == 2) {
            $message = 'Email dan No HP berhasil diperbarui.';
        } elseif ($updatedFields[0] == 'email') {
            $message = 'Email berhasil diperbarui.';
        } else {
            $message = 'No HP berhasil diperbarui.';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => [
                'email' => $user->email,
                'no_hp' => $user->no_hp,
            ],
        ], 200);

    } catch (ValidationException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validasi gagal',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
        ], 500);
    }
}

}