<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ControllerApi;
use App\Models\ClaimUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClaimUserApiController extends ControllerApi
{
    // ... (metode create dan store Anda yang sudah ada) ...

    /**
     * Menyimpan klaim baru yang diajukan oleh user.
     * (Sesuai rute POST /claims)
     */
    public function store(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'media_sosial' => 'required|string|max:255',
            'lokasi_kehilangan' => 'required|string|max:255',
            'waktu_kehilangan' => 'required|date',
            'deskripsi_claim' => 'required|string',
            'bukti_kepemilikan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $buktiKepemilikanPath = null;
        if ($request->hasFile('bukti_kepemilikan')) {
            $buktiKepemilikanPath = $request->file('bukti_kepemilikan')->store('bukti_kepemilikan', 'public');
        }

        // Buat instance ClaimUser baru
        $claim = ClaimUser::create([
            'user_id' => auth()->id(),
            'nama_lengkap' => $validated['nama_lengkap'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'media_sosial' => $validated['media_sosial'],
            'lokasi_kehilangan' => $validated['lokasi_kehilangan'],
            'waktu_kehilangan' => $validated['waktu_kehilangan'],
            'deskripsi_claim' => $validated['deskripsi_claim'],
            'bukti_kepemilikan' => $buktiKepemilikanPath,
            'status' => 'pending' // Asumsi status default saat klaim diajukan adalah 'pending'
        ]);

        // Mengembalikan respons JSON dengan data klaim yang baru dibuat
        return response()->json([
            'success' => true,
            'message' => 'Klaim barang berhasil diajukan!',
            'data' => [
                'id' => $claim->id,
                'user_id' => $claim->user_id,
                'nama_lengkap' => $claim->nama_lengkap,
                'nomor_telepon' => $claim->nomor_telepon,
                'media_sosial' => $claim->media_sosial,
                'lokasi_kehilangan' => $claim->lokasi_kehilangan,
                'waktu_kehilangan' => $claim->waktu_kehilangan,
                'deskripsi_claim' => $claim->deskripsi_claim,
                'bukti_kepemilikan_url' => $claim->bukti_kepemilikan ? Storage::url($claim->bukti_kepemilikan) : null,
                'status' => $claim->status,
                'created_at' => $claim->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $claim->updated_at->format('Y-m-d H:i:s'),
            ],
        ], 201);
    }

    public function history()
    {
        $user = auth()->user(); // Dapatkan user yang login
        $claims = ClaimUser::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $formattedClaims = $claims->map(function ($claim) {
            return [
                'id' => $claim->id,
                'nama_lengkap' => $claim->nama_lengkap,
                'status' => $claim->status,
                'created_at' => $claim->created_at->format('Y-m-d H:i:s'),
                'bukti_kepemilikan_url' => $claim->bukti_kepemilikan ? Storage::url($claim->bukti_kepemilikan) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Riwayat klaim user berhasil diambil.',
            'data' => $formattedClaims,
        ], 200);
    }

    // ... (metode index, show, history, destroy lainnya) ...
}