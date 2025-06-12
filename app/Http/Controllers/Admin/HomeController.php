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

        // Langkah 1: Ambil semua data BARANG HILANG.
        // Tambahkan atribut 'type' langsung ke objek model LostItem.
        $lostItems = LostItem::latest()->get()->map(function ($item) {
            $item->type = 'lost'; // Tambahkan atribut baru ke objek model yang sudah ada
            return $item;
        });

        // Langkah 2: Ambil semua data BARANG DITEMUKAN.
        // Tambahkan atribut 'type' langsung ke objek model FoundedItem.
        $foundedItems = FoundedItem::latest()->get()->map(function ($item) {
            $item->type = 'founded'; // Tambahkan atribut baru ke objek model yang sudah ada
            return $item;
        });

        // Langkah 3: Gabungkan kedua jenis barang menjadi satu koleksi besar
        // dan urutkan berdasarkan created_at.
        // Pastikan kedua koleksi adalah koleksi Eloquent untuk merge yang mulus
        $items = $lostItems->merge($foundedItems)->sortByDesc('created_at');

        // Langkah 4: Terapkan filter pencarian jika ada.
        if ($search) {
            $items = $items->filter(function ($item) use ($search) {
                // Pastikan properti nama yang diakses sesuai dengan model
                // Untuk LostItem: $item->lost_item_name
                // Untuk FoundedItem: $item->found_item_name
                // Karena kita menggabungkan, kita perlu memeriksa keduanya atau
                // membuat atribut "nama" di masing-masing map di atas.
                // ATAU lebih baik, buat accessor di model jika sering dipakai.

                // Untuk sementara, kita bisa cek properti mana yang ada
                $itemName = property_exists($item, 'lost_item_name') ? $item->lost_item_name : $item->found_item_name;

                return stripos($itemName, $search) !== false ||
                       stripos($item->item_description, $search) !== false;
            });
        }

        // Langkah 5: Kirim koleksi $items yang sudah lengkap dan benar ke view.
        return view('admin.home', compact('items'));
    }
}