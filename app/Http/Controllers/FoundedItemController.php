<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FoundedItem;
use Illuminate\Http\Request;
use App\Models\LostItem;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


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
            'status' => $validated['status'] ?? 'Barang Ditemukan'
        ]);

        return redirect()->route('home')->with('success', 'Barang ditemukan berhasil diposting!');

        return response()->json([
            'message' => 'Berhasil post cihuy.',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function index()
    {
        $foundedItems = FoundedItem::latest()->get();
        return view('founded_items.index', compact('foundedItems'));
    }

    public function show($id) 
    {
        $item = FoundedItem::findOrFail($id); 
        $comments = $item->comments()->latest()->get(); 
        // dd($comments->toArray(), $item->toArray()); 
        return view('founded_items.show', compact('item', 'comments'));
    }

    use AuthorizesRequests;

    public function edit($id) {
        $item = FoundedItem::findOrFail($id);
        $this->authorize('update', $item);
        return view('founded_items.edit', compact('item'));
    }


    public function update(Request $request, $id)
    {
        $item = FoundedItem::findOrFail($id);

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


        if ($request->hasFile('item_photo')) {
        
            if ($item->item_photo) {
                \Storage::disk('public')->delete($item->item_photo);
            }

            $validated['item_photo'] = $request->file('item_photo')->store('found_items_photos', 'public');
        }

        $item->update($validated);

        return redirect()->route('home')->with('success', 'Postingan berhasil diperbarui.');
    }


    public function destroy($id) {
        $item = FoundedItem::findOrFail($id);

        // Hapus file foto jika ada
        if ($item->item_photo) {
            \Storage::disk('public')->delete($item->item_photo);
        }

        // Hapus data dari database
        $item->delete();

        return redirect()->route('home')->with('success', 'Postingan berhasil dihapus.');
    }
}