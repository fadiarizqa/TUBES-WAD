<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ControllerApi;
use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LostItemApiController extends ControllerApi
{
    use AuthorizesRequests;

    public function create()
    {
        return view('lost_items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'posting_type' => 'required|string',
            'full_name' => 'required|string|max:255',
            'lost_item_name' => 'required|string|max:255',
            'item_type' => 'required|string',
            'item_description' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'social_media' => 'nullable|string|max:255',
            'item_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lost_location' => 'required|string|max:255',
            'lost_date' => 'required|date',
            'status' => 'nullable|in:hilang,diklaim,none'
        ]);

        $itemPhotoPath = null;
        if ($request->hasFile('item_photo')) {
            $itemPhotoPath = $request->file('item_photo')->store('lost_items_photos', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['item_photo'] = $itemPhotoPath;
        $validated['status'] = $validated['status'] ?? 'Barang Hilang';

        $lostItem = LostItem::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Barang hilang berhasil diposting!',
            'data' => [
                'id' => $lostItem->id,
                'user_id' => $lostItem->user_id,
                'posting_type' => $lostItem->posting_type,
                'full_name' => $lostItem->full_name,
                'lost_item_name' => $lostItem->lost_item_name,
                'item_type' => $lostItem->item_type,
                'item_description' => $lostItem->item_description,
                'phone_number' => $lostItem->phone_number,
                'social_media' => $lostItem->social_media,
                'item_photo_url' => $lostItem->item_photo ? asset('storage/' . $lostItem->item_photo) : null,
                'lost_location' => $lostItem->lost_location,
                'lost_date' => $lostItem->lost_date,
                'status' => $lostItem->status,
                'created_at' => $lostItem->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $lostItem->updated_at->format('Y-m-d H:i:s'),
            ],
        ], 201);
    }

    public function index()
    {
        $lostItems = LostItem::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar barang hilang berhasil diambil',
            'data' => $lostItems
        ], 200);
    }

    public function show($id)
    {
        $item = LostItem::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail barang hilang berhasil diambil',
            'data' => [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'posting_type' => $item->posting_type,
                'full_name' => $item->full_name,
                'lost_item_name' => $item->lost_item_name,
                'item_type' => $item->item_type,
                'item_description' => $item->item_description,
                'phone_number' => $item->phone_number,
                'social_media' => $item->social_media,
                'item_photo_url' => $item->item_photo ? asset('storage/' . $item->item_photo) : null,
                'lost_location' => $item->lost_location,
                'lost_date' => $item->lost_date,
                'status' => $item->status,
                'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $item->updated_at->format('Y-m-d H:i:s'),
            ]
        ], 200);
    }

    public function edit($id)
    {
        $item = LostItem::findOrFail($id);
        $this->authorize('update', $item);
        return view('lost_items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = LostItem::findOrFail($id);

        $validated = $request->validate([
            'posting_type' => 'required|string',
            'full_name' => 'required|string|max:255',
            'lost_item_name' => 'required|string|max:255',
            'item_type' => 'required|string',
            'item_description' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'social_media' => 'nullable|string|max:255',
            'item_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lost_location' => 'required|string|max:255',
            'lost_date' => 'required|date',
            'status' => 'nullable|in:hilang,diklaim,none'
        ]);

        if ($request->hasFile('item_photo')) {
            if ($item->item_photo) {
                Storage::disk('public')->delete($item->item_photo);
            }

            $validated['item_photo'] = $request->file('item_photo')->store('lost_items_photos', 'public');
        }

        $item->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data barang hilang berhasil diperbarui',
            'data' => $item
        ], 200);
    }

    public function destroy($id)
    {
        $item = LostItem::findOrFail($id);

        if ($item->item_photo) {
            Storage::disk('public')->delete($item->item_photo);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang hilang berhasil dihapus'
        ], 200);
    }
}
