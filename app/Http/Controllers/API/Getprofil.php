<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\master_penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Getprofil extends Controller
{
    public function index(Request $request)
    {
        $nik = $request->query('nik');

        if (!$nik) {
            return response()->json([
                'error' => 'Parameter NIK tidak ditemukan'
            ], 400);
        }

        $profil = DB::table('master_penduduks')
            ->leftJoin('master_akun', 'master_penduduks.nik', '=', 'master_akun.nik')
            ->select(
                'master_penduduks.no_kk',
                'master_penduduks.nik',
                'master_penduduks.nama_lengkap',
                'master_akun.no_hp',
                'master_akun.email',
                'master_akun.foto_profil'
            )
            ->where('master_penduduks.nik', $nik)
            ->first();

        if (!$profil) {
            return response()->json([
                'error' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'no_kk' => $profil->no_kk,
                'nik' => $profil->nik,
                'nama_lengkap' => $profil->nama_lengkap,
                'no_hp' => $profil->no_hp,
                'email' => $profil->email,
                'foto_profil' => $profil->foto_profil
                        ? asset('storage/foto_profil/' . $profil->foto_profil)
                        : asset('storage/foto_profil/default.jpg'),

            ]
        ]);

    }

    public function getByNik(Request $request)
    {
        $nik = $request->query('nik');
        $user = master_penduduk::where('nik', $nik)->first();

        if ($user) {
            return response()->json([
                'success' => true,
                'data' => [
                    'nama' => $user->nama_lengkap,
                    'nik' => $user->nik,
                    'tempatLahir' => $user->tempat_lahir,
                    'tanggalLahir' => $user->tanggal_lahir,
                    'golDarah' => $user->golongan_darah,
                    'jk' => $user->jenis_kelamin,
                    'kewarganegaraan' => $user->kewarganegaraan,
                    'agama' => $user->agama,
                    'statusKeluarga' => $user->status_keluarga,
                    'pekerjaan' => $user->pekerjaan,
                    'pendidikan' => $user->pendidikan,
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User dengan NIK tersebut tidak ditemukan.'
            ], 404);
        }
    }
}
