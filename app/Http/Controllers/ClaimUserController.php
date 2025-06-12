<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\ClaimUser;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

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
            'lokasi_kehilangan' => 'required|string|max:255',
            'waktu_kehilangan' => 'required|date',
            'deskripsi_claim' => 'required|string',
            'bukti_kepemilikan' => 'nullable|image|max:2048', // PERBAIKI: nama field konsisten
        ]);

        $itemPhotoPath = null;
        if ($request->hasFile('bukti_kepemilikan')) {
            $itemPhotoPath = $request->file('bukti_kepemilikan')->store('bukti_kepemilikan', 'public');
        }

        ClaimUser::create([
            'user_id' => auth()->id(),
            'nama_lengkap' => $validated['nama_lengkap'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'media_sosial' => $validated['media_sosial'],
            'lokasi_kehilangan' => $validated['lokasi_kehilangan'],
            'waktu_kehilangan' => $validated['waktu_kehilangan'],
            'deskripsi_claim' => $validated['deskripsi_claim'],
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

        public function history(Request $request)
    {   
        $user = Auth::user();
    
        $claims = ClaimUser::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('claim_user.history', compact('claims'));
    }

    public function destroy($id)
    {
        $claim = ClaimUser::findOrFail($id);
        $claim->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

}