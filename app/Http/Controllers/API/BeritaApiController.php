<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\master_berita;
use Illuminate\Http\Request;

class BeritaApiController extends Controller
{
    public function index()
{
    $berita = master_berita::with('penulis')
    ->latest()
    ->get()
    ->map(function ($item) {
        return [
            'idberita' => $item->id_berita,
            'judul' => $item->judul,
            'tanggal' => $item->tanggal,
            'deskripsi' => $item->deskripsi,
            'gambar' => $item->image ? asset('/storage/imageberita/' . $item->image) : null,
            'nik' => $item->nik,
            'nama' => optional($item->penulis)->nama_lengkap, // disesuaikan
        ];
    });


    return response()->json($berita);
}

public function show($id)
{
    $berita = master_berita::with('penulis')->where('id_berita', $id)->first();

    if (!$berita) {
        return response()->json(['message' => 'Not found'], 404);
    }

    return response()->json([
        'idberita' => $berita->id_berita,
        'judul' => $berita->judul,
        'tanggal' => $berita->tanggal,
        'deskripsi' => $berita->deskripsi,
        'gambar' => $berita->image ? asset('/storage/imageberita/' . $berita->image) : null,
        'nik' => $berita->nik,
        'nama' => optional($berita->penulis)->nama_lengkap,
    ]);
}


}