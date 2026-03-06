<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotifikasiPengajuan;
use App\Models\MasterPengaduan;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $nik = $request->query('nik');

        if (!$nik) {
            return response()->json([
                'error' => 'Parameter nik wajib diisi.'
            ], 400);
        }

        // Ambil satu notifikasi terbaru untuk jenis 'pengajuan'
        $pengajuan = NotifikasiPengajuan::where('nik', $nik)
            ->where('jenis', 'pengajuan')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil satu notifikasi terbaru untuk jenis 'pengaduan'
        $pengaduan = NotifikasiPengajuan::where('nik', $nik)
            ->where('jenis', 'pengaduan')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'pengajuan' => $pengajuan,
            'pengaduan' => $pengaduan,
        ]);
    }
    
   public function show($id)
{
  
    $data = MasterPengaduan::find($id);

    if (!$data) {
        return response()->json([
            'message' => 'Data pengaduan tidak ditemukan'
        ], 404);
    }

    // Mengembalikan data sebagai response JSON
    return response()->json([
        'id' => $data->id,
        'nik' => $data->nik,
        'ulasan' => $data->ulasan,
        'foto1' => $data->foto1 ? asset('/storage/' . $data->foto1) : null,
        'feedback' => $data->feedback,
        'kategori' => $data->kategori,
        'created_at' => $data->created_at,
        'updated_at' => $data->updated_at,
    ]);
}

}