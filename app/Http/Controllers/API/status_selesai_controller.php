<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class status_selesai_controller extends Controller
{
    public function index(Request $request)
    {
        $nik = $request->query('nik');
    
        if (!$nik) {
            return response()->json([
                'error' => 'NIK tidak ditemukan'
            ], 400);
        }
    
        $data = DB::table('master_pengajuan')
            ->join('master_surat', 'master_pengajuan.id_surat', '=', 'master_surat.id_surat')
            ->select(
                'master_pengajuan.id_pengajuan',
                'master_surat.nama_surat',
                'master_pengajuan.updated_at',
                'master_pengajuan.status',
                'master_pengajuan.file_pdf'
            )
            ->where('master_pengajuan.nik', $nik)
            ->where('master_pengajuan.status', 'selesai')
            ->orderBy('master_pengajuan.updated_at', 'desc')
            ->get();
    
        // Ubah path file menjadi URL
        $data->transform(function ($item) {
            if ($item->file_pdf) {
                
                $filePath = ltrim($item->file_pdf, '/');
        
                
                $item->file_pdf = asset('storage/generatesurat/' . $filePath);
            }
            return $item;
        });
    
        return response()->json($data);
    }
}
