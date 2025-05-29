<?php

namespace App\Http\Controllers;

use App\Models\LostItem; // Import the LostItem model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Needed for file storage

class LostItemController extends Controller
{
    /**
     * Display the form for posting a lost item.
     */
    public function create()
    {
        return view('lost_items.create'); // Return the lost item form view
    }

    /**
     * Store a newly created lost item in storage.
     */
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
            'item_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'lost_location' => 'required|string|max:255',
            'lost_date' => 'required|date',
        ]);

        $itemPhotoPath = null;
        if ($request->hasFile('item_photo')) {
            $itemPhotoPath = $request->file('item_photo')->store('lost_items_photos', 'public');
        }

        LostItem::create([
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
        ]);

        return redirect()->route('lost_items.create')->with('success', 'Barang hilang berhasil diposting!');
    }

    public function index()
    {
        $lostItems = LostItem::latest()->get();
        
        return view('lost_items.index', compact('lostItems')); 
    }
}