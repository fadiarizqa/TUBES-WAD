<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\FoundedItem; 
use App\Models\LostItem;   
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; 

class CommentController extends Controller
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
        $parentItem = $this->getParentItem($itemType, $itemId);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $comment = new Comment([
            'user_id' => Auth::id(), 
            'post_id' => $parentItem->id, 
            'post_type' => $itemType, 
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        $comment->save();

        return (new CommentResource($comment))->response()->setStatusCode(201);
    }

    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $comment->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return response()->json(null, 204);
    }
}