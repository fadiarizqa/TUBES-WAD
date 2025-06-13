<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ControllerApi;
use App\Models\LostItem;
use App\Models\FoundedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LostItemApiController extends ControllerApi
{
   
    public function create()
    {
        return view('lost_items.create');
    }

    public function store(Request $request)
    {
        $request->validate([

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
            'status' => 'nullable|in:hilang,diklaim,none', 
        ]);

        $itemPhotoPath = null;
        if ($request->hasFile('item_photo')) {
            $itemPhotoPath = $request->file('item_photo')->store('lost_items_photos', 'public');
        }

        LostItem::create([
            'user_id' => auth()->id(),
            'posting_type' => $request->posting_type,
            'full_name' => $request->full_name,
            'lost_item_name' => $request->lost_item_name,
            'item_type' => $request->item_type,
            'item_description' => $request->item_description,
            'phone_number' => $request->phone_number,
            'social_media' => $request->social_media,
            'item_photo' => $itemPhotoPath,
            'lost_location' => $request->lost_location,
            'lost_date' => $request->lost_date,
            'status' => $request->status ?? 'Barang Hilang', 
        ]);

        return redirect()->route('home')->with('success', 'Barang hilang berhasil diposting!');
    }

    public function index()
    {
        $lostItems = LostItem::latest()->get();
        return view('lost_items.index', compact('lostItems'));
    }

    public function show($id)
    {
        
        $item = LostItem::findOrFail($id); 
        $comments = $item->comments()->latest()->get(); 
        return view('lost_items.show', compact('item', 'comments'));
    }

    use AuthorizesRequests;

    public function edit($id) {
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
                \Storage::disk('public')->delete($item->item_photo);
            }

            $validated['item_photo'] = $request->file('item_photo')->store('lost_items_photos', 'public');
        }

        $item->update($validated);
        return redirect()->route('home')->with('success', 'Postingan berhasil diperbarui.');
    }


    public function destroy($id) {
    $item = LostItem::findOrFail($id);

    // Hapus file foto jika ada
    if ($item->item_photo) {
        \Storage::disk('public')->delete($item->item_photo);
    }

    // Hapus data dari database
    $item->delete();

    return redirect()->route('home')->with('success', 'Postingan berhasil dihapus.');
    }

    
}
