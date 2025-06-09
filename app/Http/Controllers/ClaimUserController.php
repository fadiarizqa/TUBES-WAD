<?php

namespace App\Http\Controllers;

use App\Models\ClaimUser;
use Illuminate\Http\Request;

class ClaimUserController extends Controller
{
    public function create()
    {
        return view('claim_user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'media_sosial' => 'required|string|max:255',
            'jenis_barang' => 'required|in:KTM,Barang pribadi,Barang elektronik,Peralatan',
            'deskripsi_barang' => 'required|string',
            'lokasi_kehilangan' => 'required|string|max:255',
            'waktu_kehilangan' => 'required|date',
            'bukti_kepemilikan' => 'nullable|image|max:2048', // PERBAIKI: nama field konsisten
        ]);

        $itemPhotoPath = null;
        if ($request->hasFile('bukti_kepemilikan')) {
            $itemPhotoPath = $request->file('bukti_kepemilikan')->store('bukti_kepemilikan', 'public');
        }

        ClaimUser::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'media_sosial' => $validated['media_sosial'],
            'jenis_barang' => $validated['jenis_barang'],
            'deskripsi_barang' => $validated['deskripsi_barang'],
            'lokasi_kehilangan' => $validated['lokasi_kehilangan'],
            'waktu_kehilangan' => $validated['waktu_kehilangan'],
            'bukti_kepemilikan' => $itemPhotoPath
        ]);

        return redirect()->route('home')->with('success', 'Klaim barang berhasil diajukan!');
    }

    public function index()
    {
        $claimUsers = ClaimUser::latest()->get();
        return view('claim_user.index', compact('claimUsers'));
    }

    public function show($id)
    {
        $claim = ClaimUser::findOrFail($id);
        return view('claim_user.show', compact('claim'));
    }
}