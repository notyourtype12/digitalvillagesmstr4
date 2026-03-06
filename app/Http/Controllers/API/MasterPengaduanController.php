<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPengaduan;

class MasterPengaduanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|exists:master_penduduks,nik',
            'ulasan' => 'required|string',
            'foto1' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'feedback' => 'nullable|string',
            'kategori' => 'required|string',
        ]);

        if ($request->hasFile('foto1')) {
            $validated['foto1'] = $request->file('foto1')->store('pengaduan_foto', 'public');
        }

        $data = MasterPengaduan::create($validated);
        return response()->json($data, 201);
    }
}