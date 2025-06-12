<?php

namespace App\Http\Controllers;

use App\Models\FoundedItem;
use App\Models\LostItem; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) { 
        $filter = $request->query('filter', 'all'); 

        $foundedItems = collect();
        $lostItems = collect();

        if ($filter === 'all' || $filter === 'found') {
            $foundedItems = FoundedItem::all()->map(function ($item) {
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
            $lostItems = LostItem::all()->map(function ($item) {
                return (object)[
                    'id' => $item->id,
                    'nama' => $item->lost_item_name,
                    'deskripsi' => $item->item_description,
                    'foto' => $item->item_photo,
                    'type' => 'lost', 
                ];
            });
        }

        $items = collect($foundedItems)->merge($lostItems);

        return view('home', compact('items', 'filter')); 
    }
}
