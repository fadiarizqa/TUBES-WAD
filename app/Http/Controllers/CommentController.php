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
        session()->flash('success', 'Comment berhasil disimpan!');
        return redirect()->route('founded_items.show', ['id' => $comment->post_id])->with('success', 'Komentar berhasil ditambahkan!');
        return back();
    }

    public function show(Comment $comment)
    {
        $comment = FoundedItem::findOrFail($id);
        
        return view('founded_items.show', compact('item'));
        return $comment;
    }

    public function update(Request $request, $id, Comment $comment)
    {
        $foundedItem = FoundedItem::findOrFail($id);

        Gate::authorize('update', $comment);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $comment->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('founded_items.show', $foundedItem->id)->with('success', 'Komentar berhasil diperbarui!');
    }

    public function edit($id, Comment $comment)
    {
        $foundedItem = FoundedItem::findOrFail($id); // Cari objek FoundedItem secara manual

        // Otorisasi
        Gate::authorize('update', $comment);

        // Validasi relasi (opsional tapi bagus)
        if ($comment->post_id !== $foundedItem->id || $comment->post_type !== 'found') {
            abort(404);
        }

        return view('comments.edit', compact('foundedItem', 'comment')); // Kirim juga foundedItem ke view jika perlu
    }

    public function destroy($id, Comment $comment)
    {
        $foundedItem = FoundedItem::findOrFail($id); // Cari objek FoundedItem secara manual

        // Otorisasi
        Gate::authorize('delete', $comment);

        // Validasi relasi (opsional tapi bagus)
        if ($comment->post_id !== $foundedItem->id || $comment->post_type !== 'found') {
            abort(404);
        }

        $comment->delete();

        return redirect()->route('founded_items.show', $foundedItem->id)->with('success', 'Komentar berhasil dihapus!');
    }
}
