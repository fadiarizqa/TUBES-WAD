<?php

namespace App\Http\Controllers;

use App\Models\FoundedItem;
use Illuminate\Http\Request;

class FoundedItemController extends Controller
{
    public function create()
    {
        return view('founded_items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'posting_type' => 'required|string', 
            'full_name' => 'required|string|max:255',
            'found_item_name' => 'required|string|max:255',
            'item_type' => 'required|string',
            'item_description' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'social_media' => 'nullable|string|max:255',
            'item_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'found_location' => 'required|string|max:255',
            'found_date' => 'required|date',
            'status' => 'nullable|in:ditemukan,diklaim,none'
        ]);

        $itemPhotoPath = null;
        if ($request->hasFile('item_photo')) {
            $itemPhotoPath = $request->file('item_photo')->store('found_items_photos', 'public');
        }

        FoundedItem::create([
            'user_id' => auth()->id(),
            'posting_type' => $validated['posting_type'],
            'full_name' => $validated['full_name'],
            'found_item_name' => $validated['found_item_name'],
            'item_type' => $validated['item_type'],
            'item_description' => $validated['item_description'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'social_media' => $validated['social_media'] ?? null,
            'item_photo' => $itemPhotoPath,
            'found_location' => $validated['found_location'],
            'found_date' => $validated['found_date'],
            'status' => $validated['status'] ?? 'ditemukan'
        ]);

        return redirect()->route('home')->with('success', 'Barang ditemukan berhasil diposting!');
    }

    public function index()
    {
        $foundedItems = FoundedItem::latest()->get();
        return view('founded_items.index', compact('foundedItems'));
    }
}
