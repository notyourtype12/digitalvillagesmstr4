<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\master_pengajuan;
use Illuminate\Support\Facades\DB;

class status_diajukan_controller extends Controller
{
    public function index(Request $request)
{
    $nik = $request->query('nik');

    if (!$nik) {
        return response()->json([
            'error' => 'Parameter NIK tidak ditemukan'
        ], 400);
    }

    $data = DB::table('master_pengajuan')
        ->join('master_surat', 'master_pengajuan.id_surat', '=', 'master_surat.id_surat')
        ->select(
            'master_pengajuan.id_pengajuan',
            'master_surat.nama_surat',
            'master_pengajuan.tanggal_diajukan',
            'master_pengajuan.status',

        )
        ->where('master_pengajuan.nik', $nik)
        ->whereIn('master_pengajuan.status', ['Diajukan', 'Disetujui RT', 'Disetujui RW'])
        ->get();

    return response()->json($data);
}

    public function destroy($id)
    {
        $pengajuan = master_pengajuan::find($id);

        if (!$pengajuan) {
            return response()->json([
                'error' => 'Pengajuan tidak ditemukan'
            ], 404);
        }

        $pengajuan->delete();

        return response()->json([
            'message' => 'Pengajuan berhasil dihapus'
        ]);
    }

}
