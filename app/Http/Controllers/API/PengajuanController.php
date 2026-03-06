<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\master_pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PengajuanController extends Controller
{
    

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_surat' => 'required|string',
                'nik' => 'required|string|size:16',
                'keperluan' => 'required|string|max:50',
                'tanggal_diajukan' => 'required|date',
                'foto1' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'foto2' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'foto3' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'foto4' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'foto5' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'foto6' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'foto7' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'foto8' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            ], [
                'keperluan.required' => 'Form keperluan harus diisi.',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        }
    
        $existing = master_pengajuan::where('id_surat', $request->id_surat)
            ->where('nik', $request->nik)
            ->whereNotIn('status', ['Ditolak', 'Selesai'])
            ->first();
    
        if ($existing) {
            return response()->json([
                'message' => 'Anda telah mengajukan surat ini dan masih dalam tahap proses',
            ], 409); // 409 Conflict
        }

        $fotoPaths = [];
        for ($i = 1; $i <= 8; $i++) {
            $foto = $request->file('foto' . $i);
            if ($foto) {
                $filename = 'foto' . $i . '_' . Str::random(10) . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs('public/foto_pengajuan', $filename);
                $fotoPaths['foto' . $i] = str_replace('public/', 'storage/', $path);
            } else {
                $fotoPaths['foto' . $i] = null;
            }
        }
    
        master_pengajuan::create([
            'id_surat' => $request->id_surat,
            'nik' => $request->nik,
            'keperluan' => $request->keperluan,
            'tanggal_diajukan' => $request->tanggal_diajukan,
            'status' => 'Diajukan',
            'foto1' => $fotoPaths['foto1'],
            'foto2' => $fotoPaths['foto2'],
            'foto3' => $fotoPaths['foto3'],
            'foto4' => $fotoPaths['foto4'],
            'foto5' => $fotoPaths['foto5'],
            'foto6' => $fotoPaths['foto6'],
            'foto7' => $fotoPaths['foto7'],
            'foto8' => $fotoPaths['foto8'],
            'file_pdf' => '-',
        ]);
    
        return response()->json([
            'message' => 'Pengajuan berhasil disimpan!',
        ], 200);
    }
}    