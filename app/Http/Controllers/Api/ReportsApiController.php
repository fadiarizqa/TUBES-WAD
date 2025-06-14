<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reports;
use App\Models\LostItem;
use App\Models\FoundedItem;
use Illuminate\Validation\Rule;

class ReportsApiController extends ControllerApi
{
    /**
     * @route   GET /api/reports
     * @desc    Menampilkan semua laporan
     * @access  Private (Admin)
     */
    public function index()
    {
        $reports = Reports::with(['post', 'user'])->latest()->get();

        // Cek jika tidak ada laporan sama sekali
        if ($reports->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Belum ada laporan yang masuk saat ini.',
                'data'    => [] // Tetap kirim array kosong
            ]);
        }

        // Jika ada laporan, kirim seperti biasa
        return response()->json([
            'success' => true,
            'message' => 'Data semua laporan berhasil diambil.',
            'data'    => $reports
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
   $postType = $request->get('post_type');
        $postId = $request->get('post_id');

        $modelClass = new $postType;
        $item = $modelClass::findOrFail($postId);

        return view('reports.create', [
            'item' => $item,
            'post_id' => $postId,
            'post_type' => $postType
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id'   => 'required|integer',
            'post_type' => 'required|string',
            'reason'    => 'required|string|max:500',
        ]);

        $alreadyReported = Reports::where('user_id', Auth::id())
            ->where('post_id', $validated['post_id'])
            ->where('post_type', $validated['post_type'])
            ->exists();

        if ($alreadyReported) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah pernah melaporkan postingan ini sebelumnya.',
                'data'    => null
            ], 409);
        }

        $report = Reports::create([
            'user_id'   => Auth::id(),
            'post_id'   => $validated['post_id'],
            'post_type' => $validated['post_type'],
            'reason'    => $validated['reason'],
            'status'    => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim dan akan segera ditinjau oleh admin.',
            'data'    => $report
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        
        $report = Reports::with('post', 'user')->find($id); 

        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan dengan ID ' . $id . ' tidak ditemukan.',
                'data'    => null
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Detail laporan berhasil diambil.',
            'data'    => $report
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,rejected',
        ]);

        $report = Reports::find($id);

        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan dengan ID ' . $id . ' tidak ditemukan.',
                'data'    => null
            ], 404);
        }
        
        $report->update([
            'status' => $validated['status']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status laporan berhasil diperbarui.',
            'data'    => $report->fresh()
        ]);  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $report = Reports::find($id);

        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan dengan ID ' . $id . ' tidak ditemukan.',
                'data'    => null
            ], 404);
        }

        // Periksa apakah status laporan adalah 'rejected'
        if ($report->status !== 'rejected') {
            return response()->json([
                'success' => false,
                'message' => 'Gagal! Laporan hanya dapat dihapus jika statusnya "Rejected".',
                'data'    => null
            ], 400); // 400 Bad Request
        }
        
        // Jika statusnya 'rejected', hapus laporan
        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dihapus.',
            'data'    => null
        ]);
    }

    public function destroyPost(Reports $report)
    {
        if ($report->status !== 'reviewed') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya postingan dari laporan yang sudah direview yang bisa dihapus.',
                'data'    => null
            ], 403);
        }

        $post = $report->post;

        if ($post) {
            $post->delete();
            $report->delete();

            return response()->json([
                'success' => true,
                'message' => 'Postingan terkait telah berhasil dihapus.',
                'data'    => null
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Postingan tidak ditemukan atau sudah dihapus sebelumnya.',
            'data'    => null
        ], 404);
    }
}
