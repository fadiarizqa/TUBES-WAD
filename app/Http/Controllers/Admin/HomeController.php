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
        // Fungsi `map` di bawah ini akan memformat setiap item satu per satu.
        $lostItems = LostItem::latest()->get()->map(function ($item) {
            // Untuk setiap item yang hilang, kita secara eksplisit membuat objek baru
            // dan mengatur 'type' menjadi 'lost'.
            return (object)[
                'id'          => $item->id,
                'nama'        => $item->lost_item_name,
                'deskripsi'   => $item->item_description,
                'foto'        => $item->item_photo,
                'type'        => 'lost', // <-- Data type dipastikan 'lost'
                'created_at'  => $item->created_at,
            ];
        });

        // Langkah 2: Ambil semua data BARANG DITEMUKAN.
        $foundedItems = FoundedItem::latest()->get()->map(function ($item) {
            // Untuk setiap item yang ditemukan, kita membuat objek baru
            // dan mengatur 'type' menjadi 'founded' agar bisa dibedakan.
            return (object)[
                'id'          => $item->id,
                'nama'        => $item->found_item_name,
                'deskripsi'   => $item->item_description,
                'foto'        => $item->item_photo,
                'type'        => 'founded', // <-- Data type dipastikan 'founded'
                'created_at'  => $item->created_at,
            ];
        });

        // Langkah 3: Gabungkan kedua jenis barang menjadi satu koleksi besar
        // dan urutkan berdasarkan tanggal postingan terbaru.
        $items = $lostItems->merge($foundedItems)->sortByDesc('created_at');

        // Langkah 4: Terapkan filter pencarian jika ada.
        if ($search) {
            $items = $items->filter(function ($item) use ($search) {
                return stripos($item->nama, $search) !== false ||
                       stripos($item->deskripsi, $search) !== false;
            });
        }

        // Langkah 5: Kirim koleksi $items yang sudah lengkap dan benar ke view.
        return view('admin.home', compact('items'));
    }
}
