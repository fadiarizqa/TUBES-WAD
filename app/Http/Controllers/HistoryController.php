<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\FoundedItem;
use App\Models\LostItem; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user(); 
        $filter = $request->query('filter', 'all');

        $foundedItems = collect();
        $lostItems = collect();

        if ($filter === 'all' || $filter === 'found') {
            $foundedItems = FoundedItem::where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->get();
        }

        if ($filter === 'all' || $filter === 'lost') {
            $lostItems = LostItem::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        }

        $allPosts = collect();

        foreach ($foundedItems as $item) {
            $item->posting_type = 'Barang Ditemukan';
            $allPosts->push($item);
        }

        foreach ($lostItems as $item) {
            $item->posting_type = 'Barang Hilang';
            $allPosts->push($item);
        }

        $allPosts = $allPosts->sortByDesc('created_at');

        return view('history.index', compact('allPosts', 'filter'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_type' => 'required|string',
            'action' => 'required|string'
        ]);

        return History::create($validated);
    }

    public function show(History $history)
    {
        return $history;
    }

    public function update(Request $request, History $history)
    {
        $history->update($request->all());
        return $history;
    }

    public function destroy(History $history)
    {
        $history->delete();
        return response()->noContent();
    }
}
