<?php

namespace App\Http\Controllers;

use App\Models\FoundedItem;
use App\Models\LostItem;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $foundedItems = FoundedItem::all()->map(function ($item) {
            return (object)[
                'id' => $item->id,
                'nama' => $item->found_item_name,
                'deskripsi' => $item->item_description,
                'foto' => $item->item_photo,
                'type' => 'founded',
            ];
        });

        $lostItems = LostItem::all()->map(function ($item) {
            return (object)[
                'id' => $item->id,
                'nama' => $item->lost_item_name,
                'deskripsi' => $item->item_description,
                'foto' => $item->item_photo,
                'type' => 'lost',
            ];
        });

        $items = collect($foundedItems)->merge($lostItems);

        return view('home', compact('items'));
    }
}
