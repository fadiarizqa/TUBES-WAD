<?php

namespace App\Http\Controllers;
use App\Models\FoundedItem;
use App\Models\Comment;
use Illuminate\Http\Request;

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

    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->all());
        return $comment;
    }

    public function destroy(Comment $comment)
    {
        $foundedId = $comment->id;
        $comment->delete();
    
        session()->flash('success', 'Comment berhasil dihapus!');
        return redirect()->route('founded_items.show', ['item' => $foundedId]);
    }
}
