<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoundedItem;
use App\Models\LostItem;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk admin.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil semua item yang hilang dan petakan ke objek standar
        $lostItems = LostItem::latest()->get()->map(function ($item) {
            return (object)[
                'id' => $item->id,
                'nama' => $item->lost_item_name,
                'deskripsi' => $item->item_description,
                'foto' => $item->item_photo,
                'type' => 'lost',
                'created_at' => $item->created_at, // Sertakan untuk pengurutan
            ];
        });

        // Ambil semua item yang ditemukan dan petakan ke objek standar
        $foundedItems = FoundedItem::latest()->get()->map(function ($item) {
            return (object)[
                'id' => $item->id,
                'nama' => $item->found_item_name,
                'deskripsi' => $item->item_description,
                'foto' => $item->item_photo,
                'type' => 'found',
                'created_at' => $item->created_at, // Sertakan untuk pengurutan
            ];
        });

        // Gabungkan kedua koleksi dan urutkan berdasarkan tanggal terbaru
        $items = $lostItems->merge($foundedItems)->sortByDesc('created_at');

        // Jika ada pencarian, filter koleksi gabungan
        if ($search) {
            $items = $items->filter(function ($item) use ($search) {
                // Cari berdasarkan nama atau deskripsi barang
                return stripos($item->nama, $search) !== false ||
                       stripos($item->deskripsi, $search) !== false;
            });
        }

        // Kirim variabel 'items' yang sudah berisi data ke view
        return view('admin.home', compact('items')); 
    }
}
