<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ControllerApi;
use App\Models\ClaimUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Tambahkan untuk mengelola file

class ClaimUserApiController extends ControllerApi
{
    /**
     * Mengembalikan data atau informasi yang diperlukan untuk membuat klaim baru.
     * (Sesuai rute GET /claims/create)
     */
    public function create()
    {
        // Untuk API, metode 'create' biasanya mengembalikan data seperti daftar pilihan
        // atau skema yang dibutuhkan klien untuk menampilkan form.
        // Dalam kasus ini, mungkin tidak ada data spesifik yang perlu dikembalikan,
        // tapi kita bisa mengembalikan konfirmasi kesiapan.
        return response()->json([
            'success' => true,
            'message' => 'Siap untuk membuat klaim baru.',
            'data' => null // Atau sertakan data default/opsi jika ada
        ], 200);
    }

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
            'bukti_kepemilikan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tambahkan validasi tipe file dan ukuran
        ]);

        $buktiKepemilikanPath = null;
        if ($request->hasFile('bukti_kepemilikan')) {
            // Simpan file ke storage 'public/bukti_kepemilikan'
            $buktiKepemilikanPath = $request->file('bukti_kepemilikan')->store('bukti_kepemilikan', 'public');
        }

        // Buat instance ClaimUser baru
        $claim = ClaimUser::create([
            'user_id' => auth()->id(), // Mengambil ID user yang sedang login
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
        ], 201); // Kode status 201 Created untuk resource baru
    }

    // --- Metode di bawah ini tidak terhubung dengan rute yang Anda berikan,
    // --- namun saya modifikasi untuk mengembalikan JSON jika nanti ada rutenya.

    /**
     * Mengambil daftar klaim pengguna.
     * (Jika ada rute GET /claims atau semacamnya)
     */
    public function index()
    {
        $claimUsers = ClaimUser::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar klaim pengguna berhasil diambil.',
            'data' => $claimUsers->map(function($claim) {
                return [
                    'id' => $claim->id,
                    'user_id' => $claim->user_id,
                    'nama_lengkap' => $claim->nama_lengkap,
                    'status' => $claim->status,
                    'created_at' => $claim->created_at->format('Y-m-d H:i:s'),
                ];
            })
        ], 200);
    }

    /**
     * Mengambil detail klaim spesifik berdasarkan ID.
     * (Jika ada rute GET /claims/{id})
     */
    public function show($id)
    {
        $claim = ClaimUser::find($id);

        if (!$claim) {
            return response()->json([
                'success' => false,
                'message' => 'Klaim tidak ditemukan.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail klaim berhasil diambil.',
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
        ], 200);
    }

    /**
     * Mengambil riwayat klaim untuk user yang sedang login.
     * (Sesuai rute GET /history)
     * Catatan: Rute /history di API Anda saat ini menunjuk ke HistoryApiController.
     * Jika Anda ingin fungsionalitas ini di ClaimUserApiController, Anda perlu mengubah rute.
     */
    public function history(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terautentikasi.',
                'data' => null
            ], 401); // 401 Unauthorized
        }

        $claims = ClaimUser::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json([
            'success' => true,
            'message' => 'Riwayat klaim user berhasil diambil.',
            'data' => $claims->map(function($claim) {
                return [
                    'id' => $claim->id,
                    'nama_lengkap' => $claim->nama_lengkap,
                    'status' => $claim->status,
                    'created_at' => $claim->created_at->format('Y-m-d H:i:s'),
                    'bukti_kepemilikan_url' => $claim->bukti_kepemilikan ? Storage::url($claim->bukti_kepemilikan) : null,
                ];
            })
        ], 200);
    }

    /**
     * Menghapus klaim.
     * (Jika ada rute DELETE /claims/{id})
     */
    public function destroy($id)
    {
        $claim = ClaimUser::find($id);

        if (!$claim) {
            return response()->json([
                'success' => false,
                'message' => 'Klaim tidak ditemukan.',
                'data' => null
            ], 404);
        }

        // Hapus file bukti kepemilikan dari storage jika ada
        if ($claim->bukti_kepemilikan) {
            Storage::disk('public')->delete($claim->bukti_kepemilikan);
        }

        $claim->delete();

        return response()->json([
            'success' => true,
            'message' => 'Klaim berhasil dihapus.',
            'data' => ['id' => $id] // Mengembalikan ID yang dihapus
        ], 200); // Atau 204 No Content untuk penghapusan
    }
}