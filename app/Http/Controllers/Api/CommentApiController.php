<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ControllerApi;
use App\Models\FoundedItem;
use App\Models\LostItem;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentApiController extends ControllerApi
{
    private function getParentItem(string $itemType, int $itemId) // Ini harus 2 parameter
    {
        try {
            if ($itemType === 'found') {
                return FoundedItem::findOrFail($itemId);
            } elseif ($itemType === 'lost') {
                return LostItem::findOrFail($itemId);
            }
            abort(response()->json([
                'success' => false,
                'message' => 'Tipe item tidak valid. Harus "found" atau "lost".'
            ], 400));
        } catch (ModelNotFoundException $e) {
            abort(response()->json([
                'success' => false,
                'message' => 'Item induk tidak ditemukan.'
            ], 404));
        }
    }
    
    // public function index()
    // {
    //     return Comment::all();
    // }

    public function index(Request $request, int $id) // <-- Signature untuk GET /api/founded_items/{id}/comments
    {
        try {
            $parentItem = $this->getParentItem('found', $id); // Hardcode 'found' karena rute spesifik
            $comments = $parentItem->comments()->latest()->get();

            // Format data secara manual (tanpa Resource)
            $formattedComments = $comments->map(function ($comment) {
                return $this->formatCommentResponse($comment);
            });

            return response()->json([
                'success' => true,
                'message' => 'Daftar komentar berhasil diambil.',
                'data' => $formattedComments->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil komentar.',
                'errors' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }
    public function store(Request $request, int $id) // <-- Signature untuk POST /api/founded_items/{id}/comments
    {
        try {
            // Dapatkan objek parent item untuk verifikasi
            // Hardcode 'found' karena rute spesifik untuk founded_items
            $parentItem = $this->getParentItem('found', $id);

            // Validasi data yang masuk dari request body
            $request->validate([
                // 'post_id' dan 'post_type' diambil dari URL/hardcode, tidak perlu divalidasi dari body
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            // Buat instance Comment baru
            $comment = new Comment([
                'user_id' => Auth::id(), // ID user yang terautentikasi
                'post_id' => $parentItem->id, // ID item induk yang sudah diverifikasi
                'post_type' => 'found', // Hardcode 'found' karena rute spesifik
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ]);

            $comment->save();

            // Kembalikan respons JSON sukses
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dibuat.',
                'data' => $this->formatCommentResponse($comment) // Format komentar sebagai array
            ], 201); // 201 Created
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422); // 422 Unprocessable Entity
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login untuk membuat komentar.',
                'errors' => $e->getMessage()
            ], 401); // 401 Unauthorized
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat komentar. Item induk tidak ditemukan atau terjadi kesalahan server.',
                'errors' => $e->getMessage()
            ], $e->getCode() ?: 500); // Gunakan kode status dari exception jika ada, atau default 500
        }
    }

    // private function getParentItem(int $id, string $postType)
    // {
    //     if ($postType === 'found') {
    //         return FoundedItem::findOrFail($id);
    //     } elseif ($postType === 'lost') {
    //         return LostItem::findOrFail($id);
    //     }
    //     abort(404, 'Tipe postingan tidak valid.'); 
    // }

    // public function store(Request $request, FoundedItem $item)
    // {
    //     $request->validate([
    //         'post_type' => 'required|in:lost,found',
    //         'post_id' => 'required|integer',
    //         'title' => 'required|string|max:255',
    //         'content' => 'required|string',
    //     ]);

    //     $comment=new Comment([
    //         'user_id' => auth()->id(),
    //         'title' => $request->input('title'),      
    //         'content' => $request->input('content'),                        
    //         'post_id' => $request->input('post_id'),   
    //         'post_type' => $request->input('post_type'),
    //     ]);

    //     $comment->save();

    //     $validated['user_id'] = Auth::id(); 
    //     $comments = Comment::create($validated); 

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Barang ditemukan berhasil diposting!',
    //         'data' => [
    //             'id' => $comments->id,
    //             'user_id' => $comments->user_id,
    //             'post_type' => $comments->post_type,
    //             'title' => $comments->title,
    //             'content' => $comments->content
    //         ],
    //     ], 201); 

    // }

    // public function show(Comment $comment)
    // {
    //     $comment = FoundedItem::findOrFail($id);
        
    //     return view('founded_items.show', compact('item'));
    //     return $comment;
    // }

    public function show(Comment $comment) // <-- Signature ini benar untuk /api/comments/{comment}
    {
        try {
            // Otorisasi opsional jika hanya user tertentu boleh melihat
            // Gate::authorize('view', $comment);

            return response()->json([
                'success' => true,
                'message' => 'Detail komentar berhasil diambil.',
                'data' => $this->formatCommentResponse($comment)
            ]); // 200 OK
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak diizinkan melihat komentar ini.',
                'errors' => $e->getMessage()
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Komentar tidak ditemukan atau terjadi kesalahan server.',
                'errors' => $e->getMessage()
            ], $e instanceof ModelNotFoundException ? 404 : 500);
        }
    }

    // public function update(Request $request, $id, Comment $comment)
    // {
    //     $parentItem = $this->getParentItem($id, $comment->post_type);

    //     if ($comment->post_id !== $parentItem->id) {
    //         abort(404, 'Komentar tidak ditemukan untuk item ini atau URL tidak valid.');
    //     }

    //     Gate::authorize('update', $comment);

    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'content' => 'required|string',
    //     ]);

    //     $comment->update([
    //         'title' => $request->input('title'),
    //         'content' => $request->input('content'),
    //     ]);

    //     if ($comment->post_type === 'found') {
    //         return redirect()->route('founded_items.show', $parentItem->id)->with('success', 'Komentar berhasil diperbarui!');
    //     } elseif ($comment->post_type === 'lost') {
    //         return redirect()->route('lost_items.show', $parentItem->id)->with('success', 'Komentar berhasil diperbarui!');
    //     }
    //     return back()->with('error', 'Gagal memperbarui komentar. Tipe postingan tidak valid.');
    // }

    public function update(Request $request, Comment $comment) // <-- Signature ini benar untuk /api/comments/{comment}
    {
        try {
            Gate::authorize('update', $comment); // Otorisasi

            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            $comment->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil diperbarui.',
                'data' => $this->formatCommentResponse($comment)
            ]); // 200 OK
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak diizinkan memperbarui komentar ini.'
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui komentar.'
            ], 500);
        }
    }

    public function edit($id, Comment $comment)
    {
        $parentItem = $this->getParentItem($id, $comment->post_type);

        if ($comment->post_id !== $parentItem->id) {
            abort(404, 'Komentar tidak ditemukan untuk item ini atau URL tidak valid.');
        }

        Gate::authorize('update', $comment); 
        return view('comments.edit', compact('parentItem', 'comment'));
    }

    // public function destroy($id, Comment $comment)
    // {
    //     $parentItem = $this->getParentItem($id, $comment->post_type);

    //     if ($comment->post_id !== $parentItem->id) {
    //         abort(404, 'Komentar tidak ditemukan untuk item ini atau URL tidak valid.');
    //     }

    //     Gate::authorize('delete', $comment); 
    //     $comment->delete();

    //     if ($comment->post_type === 'found') {
    //         return redirect()->route('founded_items.show', $parentItem->id)->with('success', 'Komentar berhasil dihapus!');
    //     } elseif ($comment->post_type === 'lost') {
    //         return redirect()->route('lost_items.show', $parentItem->id)->with('success', 'Komentar berhasil dihapus!');
    //     }
    //     return back()->with('error', 'Gagal menghapus komentar. Tipe postingan tidak valid.');
    // }

    public function destroy(Comment $comment) // <-- Signature ini benar untuk /api/comments/{comment}
    {
        try {
            Gate::authorize('delete', $comment); // Otorisasi
            $comment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus.'
            ], 204); // 204 No Content
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak diizinkan menghapus komentar ini.'
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus komentar.'
            ], 500);
        }
    }

    private function formatCommentResponse(Comment $comment): array
    {
        return [
            'id' => $comment->id,
            'title' => $comment->title,
            'content' => $comment->content,
            'user_id' => $comment->user_id,
            'user_name' => $comment->user->name ?? 'Guest', // Pastikan relasi user ada
            'post_id' => $comment->post_id,
            'post_type' => $comment->post_type,
            'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $comment->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}