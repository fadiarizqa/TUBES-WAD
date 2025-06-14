<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ControllerApi;
use App\Models\FoundedItem;
use Illuminate\Http\Request;
use App\Models\LostItem;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class FoundedItemApiController extends ControllerApi
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

        $validated['user_id'] = Auth::id(); 
        $validated['item_photo'] = $itemPhotoPath; 
        $foundedItem = FoundedItem::create($validated); 

        return response()->json([
            'success' => true,
            'message' => 'Barang ditemukan berhasil diposting!',
            'data' => [
                'id' => $foundedItem->id,
                'user_id' => $foundedItem->user_id,
                'posting_type' => $foundedItem->posting_type,
                'full_name' => $foundedItem->full_name,
                'found_item_name' => $foundedItem->found_item_name,
                'item_type' => $foundedItem->item_type,
                'item_description' => $foundedItem->item_description,
                'phone_number' => $foundedItem->phone_number,
                'social_media' => $foundedItem->social_media,
                'item_photo_url' => asset('storage/' . $foundedItem->item_photo), 
                'found_location' => $foundedItem->found_location,
                'found_date' => $foundedItem->found_date,
                'status' => $foundedItem->status,
                'created_at' => $foundedItem->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $foundedItem->updated_at->format('Y-m-d H:i:s'),
            ],
        ], 201); 

    }

    public function index()
    {
        $foundedItems = FoundedItem::latest()->get();

        return response()->json([
        'success' => true,
        'message' => 'Data barang ditemukan berhasil diambil',
        'data' => $foundedItems
    ], 200);
    }

    public function show($id) 
    {
        $item = FoundedItem::findOrFail($id); 
        $comments = $item->comments()->latest()->get(); 
        // dd($comments->toArray(), $item->toArray()); 
        // return view('founded_items.show', compact('item', 'comments'));
        return response()->json([
        'success' => true,
        'message' => 'Data barang ditemukan berhasil diambil',
        'data' => $item
    ], 200);
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

        return response()->json([
        'success' => true,
        'message' => 'Data barang ditemukan berhasil diperbarui',
        'data' => [
            'id' => $item->id,
            'user_id' => $item->user_id,
            'posting_type' => $item->posting_type,
            'full_name' => $item->full_name,
            'found_item_name' => $item->found_item_name,
            'item_type' => $item->item_type,
            'item_description' => $item->item_description,
            'phone_number' => $item->phone_number,
            'social_media' => $item->social_media,
            'item_photo_url' => $item->item_photo ? asset('storage/' . $item->item_photo) : null,
            'found_location' => $item->found_location,
            'found_date' => $item->found_date,
            'status' => $item->status,
            'created_at' => $item->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $item->updated_at->format('Y-m-d H:i:s'),
        ]
        ], 200);

        
    }


    public function destroy($id) {
        $item = FoundedItem::findOrFail($id);

        // Hapus file foto jika ada
        if ($item->item_photo) {
            \Storage::disk('public')->delete($item->item_photo);
        }

        // Hapus data dari database
        $item->delete();

        return response()->json([
        'success' => true,
        'message' => 'Postingan berhasil dihapus.',
        'data' => [
            'id' => $id,
        ]
    ], 200);
    }
}