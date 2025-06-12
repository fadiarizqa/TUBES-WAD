<?php

namespace App\Http\Controllers;
use App\Models\FoundedItem;
use App\Models\LostItem;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::all();
    }

    private function getParentItem(int $id, string $postType)
    {
        if ($postType === 'found') {
            return FoundedItem::findOrFail($id);
        } elseif ($postType === 'lost') {
            return LostItem::findOrFail($id);
        }
        abort(404, 'Tipe postingan tidak valid.'); 
    }

    public function store(Request $request, FoundedItem $item)
    {
        $request->validate([
            'post_type' => 'required|in:lost,found',
            'post_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $comment=new Comment([
            'user_id' => auth()->id(),
            'title' => $request->input('title'),      
            'content' => $request->input('content'),                        
            'post_id' => $request->input('post_id'),   
            'post_type' => $request->input('post_type'),
        ]);

        $comment->save();

        if ($comment->post_type === 'found') { 
            return redirect()->route('founded_items.show', $comment->post_id)->with('success', 'Komentar berhasil ditambahkan!');
            return back();
        } elseif ($comment->post_type === 'lost') { 
            return redirect()->route('lost_items.show', $comment->post_id)->with('success', 'Komentar berhasil ditambahkan!');
            return back();
        }
    }

    public function show(Comment $comment)
    {
        $comment = FoundedItem::findOrFail($id);
        
        return view('founded_items.show', compact('item'));
        return $comment;

    }

    public function update(Request $request, $id, Comment $comment)
    {
        $parentItem = $this->getParentItem($id, $comment->post_type);

        // Verifikasi bahwa komentar ini memang milik item induk di URL
        if ($comment->post_id !== $parentItem->id) {
            abort(404, 'Komentar tidak ditemukan untuk item ini atau URL tidak valid.');
        }

        Gate::authorize('update', $comment); // Policy sudah menangani otorisasi user

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $comment->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        // Redirect berdasarkan tipe parent item
        if ($comment->post_type === 'found') {
            return redirect()->route('founded_items.show', $parentItem->id)->with('success', 'Komentar berhasil diperbarui!');
        } elseif ($comment->post_type === 'lost') {
            return redirect()->route('lost_items.show', $parentItem->id)->with('success', 'Komentar berhasil diperbarui!');
        }
        return back()->with('error', 'Gagal memperbarui komentar. Tipe postingan tidak valid.');
    }

    public function edit($id, Comment $comment)
    {
        $parentItem = $this->getParentItem($id, $comment->post_type);

        // Verifikasi bahwa komentar ini memang milik item induk di URL
        if ($comment->post_id !== $parentItem->id) {
            abort(404, 'Komentar tidak ditemukan untuk item ini atau URL tidak valid.');
        }

        Gate::authorize('update', $comment); // Policy sudah menangani otorisasi user

        // Jika Anda menggunakan form edit terpisah, ini akan menampilkan view:
        return view('comments.edit', compact('parentItem', 'comment'));
    }

    public function destroy($id, Comment $comment)
    {
        $parentItem = $this->getParentItem($id, $comment->post_type);

        // Verifikasi bahwa komentar ini memang milik item induk di URL
        if ($comment->post_id !== $parentItem->id) {
            abort(404, 'Komentar tidak ditemukan untuk item ini atau URL tidak valid.');
        }

        Gate::authorize('delete', $comment); // Policy sudah menangani otorisasi user

        $comment->delete();

        // Redirect berdasarkan tipe parent item
        if ($comment->post_type === 'found') {
            return redirect()->route('founded_items.show', $parentItem->id)->with('success', 'Komentar berhasil dihapus!');
        } elseif ($comment->post_type === 'lost') {
            return redirect()->route('lost_items.show', $parentItem->id)->with('success', 'Komentar berhasil dihapus!');
        }
        return back()->with('error', 'Gagal menghapus komentar. Tipe postingan tidak valid.');
    }
}
