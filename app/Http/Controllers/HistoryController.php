<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $history = History::latest()->get();
        return view('history.index', compact('history'));
        // return History::all();
        
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
