<?php

namespace App\Http\Controllers;

use App\Models\FoundedItem;
use Illuminate\Http\Request;

class FoundedItemController extends Controller
{
    public function index()
    {
        return FoundedItem::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'found_date' => 'required|date',
            'status' => 'required|string',
            'claimed_by' => 'nullable|integer'
        ]);

        return FoundedItem::create($validated);
    }

    public function show(FoundedItem $foundedItem)
    {
        return $foundedItem;
    }

    public function update(Request $request, FoundedItem $foundedItem)
    {
        $foundedItem->update($request->all());
        return $foundedItem;
    }

    public function destroy(FoundedItem $foundedItem)
    {
        $foundedItem->delete();
        return response()->noContent();
    }
}
