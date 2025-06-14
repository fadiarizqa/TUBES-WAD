<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ControllerApi;
use App\Models\Comment;
use App\Models\FoundedItem; 
use App\Models\LostItem;   
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; 

class CommentApiController extends ControllerApi
{
    private function getParentItem(string $post_type, int $itemId)
    {
        if ($itemType === 'found') {
            return FoundedItem::findOrFail($itemId);
        } elseif ($itemType === 'lost') {
            return LostItem::findOrFail($itemId);
        }
        abort(response()->json(['message' => 'Invalid item type provided. Must be "found" or "lost".'], 400));
    }

    public function index(Request $request, string $itemType, int $itemId)
    {
        $parentItem = $this->getParentItem($itemType, $itemId);

        $comments = $parentItem->comments()->latest()->get();

        return CommentResource::collection($comments);
    }

    public function store(Request $request, string $itemType, int $itemId)
    {
        // Dapatkan objek item induk untuk memverifikasi keberadaan dan ID-nya.
        $parentItem = $this->getParentItem($itemType, $itemId);

        // Validasi data yang masuk dari request API.
        // post_type dan post_id akan diambil dari parameter URL, jadi tidak perlu divalidasi dari body request.
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Buat instance Comment baru.
        $comment = new Comment([
            'user_id' => Auth::id(), // Ambil ID pengguna yang sedang terautentikasi (membutuhkan middleware 'auth:sanctum').
            'post_id' => $parentItem->id, // Gunakan ID dari objek item induk yang diverifikasi.
            'post_type' => $itemType, // Gunakan tipe item dari URL (misal: 'found' atau 'lost').
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        // Simpan komentar ke database.
        $comment->save();

        // Kembalikan komentar yang baru dibuat menggunakan CommentResource dengan status HTTP 201 Created.
        return (new CommentResource($comment))->response()->setStatusCode(201);
    }

    /**
     * Menampilkan detail satu komentar spesifik.
     * Endpoint: GET /api/comments/{comment}
     *
     * @param  \App\Models\Comment  $comment  Objek Comment yang diikat oleh Route Model Binding.
     * @return \App\Http\Resources\CommentResource Detail komentar.
     */
    public function show(Comment $comment)
    {
        // Mengembalikan detail komentar tunggal menggunakan CommentResource.
        return new CommentResource($comment);
    }

    /**
     * Memperbarui komentar yang spesifik di database.
     * Endpoint: PUT /api/comments/{comment}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment  Objek Comment yang akan diperbarui.
     * @return \App\Http\Resources\CommentResource|\Illuminate\Http\JsonResponse Komentar yang diperbarui.
     */
    public function update(Request $request, Comment $comment)
    {
        // Otorisasi tindakan menggunakan CommentPolicy.
        // Ini memastikan bahwa hanya pengguna yang berhak (misal: pemilik komentar) yang bisa memperbarui.
        Gate::authorize('update', $comment);

        // Validasi data request untuk pembaruan.
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Perbarui atribut komentar.
        $comment->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        // Kembalikan komentar yang diperbarui menggunakan CommentResource.
        return new CommentResource($comment);
    }

    /**
     * Menghapus komentar yang spesifik dari database.
     * Endpoint: DELETE /api/comments/{comment}
     *
     * @param  \App\Models\Comment  $comment  Objek Comment yang akan dihapus.
     * @return \Illuminate\Http\JsonResponse Respons kosong dengan status 204.
     */
    public function destroy(Comment $comment)
    {
        // Otorisasi tindakan menggunakan CommentPolicy.
        // Ini memastikan bahwa hanya pengguna yang berhak (misal: pemilik komentar) yang bisa menghapus.
        Gate::authorize('delete', $comment);

        // Hapus komentar dari database.
        $comment->delete();

        // Kembalikan respons HTTP 204 No Content, menunjukkan penghapusan berhasil tanpa konten untuk dikembalikan.
        return response()->json(null, 204);
    }
}