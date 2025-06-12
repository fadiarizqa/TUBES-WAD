<?php

namespace App\Http\Controllers;

use App\Models\FoundedItem;
use App\Models\LostItem;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $search = $request->query('search');

        $foundedItemsQuery = FoundedItem::query();
        $lostItemsQuery = LostItem::query();

        // Apply search filter if present
        if ($search) {
            $foundedItemsQuery->where(function ($query) use ($search) {
                $query->where('found_item_name', 'like', '%' . $search . '%')
                      ->orWhere('item_description', 'like', '%' . $search . '%');
            });
            $lostItemsQuery->where(function ($query) use ($search) {
                // PERBAIKAN DI SINI: Ganti 'item_name' dengan nama kolom yang benar di tabel 'lost_items'
                // Misalnya, jika nama kolomnya 'lost_item_name':
                $query->where('lost_item_name', 'like', '%' . $search . '%') // <--- KOREKSI INI
                      ->orWhere('item_description', 'like', '%' . $search . '%');
            });
        }

        $foundedItems = collect();
        $lostItems = collect();

        if ($filter === 'all' || $filter === 'found') {
            $foundedItems = $foundedItemsQuery->get()->map(function ($item) {
                return (object)[
                    'id' => $item->id,
                    'nama' => $item->found_item_name,
                    'deskripsi' => $item->item_description,
                    'foto' => $item->item_photo,
                    'type' => 'founded',
                ];
            });
        }

        if ($filter === 'all' || $filter === 'lost') {
            $lostItems = $lostItemsQuery->get()->map(function ($item) {
                return (object)[
                    'id' => $item->id,
                    // PERBAIKAN DI SINI: Ganti 'item_name' dengan nama kolom yang benar di tabel 'lost_items' untuk mapping
                    'nama' => $item->lost_item_name, // <--- KOREKSI INI (sesuai dengan yang di atas)
                    'deskripsi' => $item->item_description,
                    'foto' => $item->item_photo,
                    'type' => 'lost',
                ];
            });
        }

        $items = collect($foundedItems)->merge($lostItems);

        return view('home', compact('items', 'filter', 'search'));
    }
}