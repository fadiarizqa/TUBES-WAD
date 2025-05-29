<!-- resources/views/components/sidebar.blade.php -->
<div class="sidebar">
    <ul>
        <li><a href="/dashboard">Beranda</a></li>
        <li><a href="/posting-barang">Posting Barang</a></li>
        <li><a href="/riwayat-posting">Riwayat Posting</a></li>
        <li><a href="/logout">Logout</a></li>
    </ul>
</div>

<aside class="w-64 bg-white border-r min-h-screen">
    <div class="p-6 font-bold text-xl">Carikeun</div>
    <nav class="mt-4">
        <a href="/beranda" class="block px-6 py-2 text-gray-700 hover:bg-gray-100 {{ request()->is('beranda') ? 'bg-slate-900 text-white rounded' : '' }}">
            Beranda
        </a>
        <a href="/posting" class="block px-6 py-2 text-gray-700 hover:bg-gray-100 {{ request()->is('posting') ? 'bg-slate-900 text-white rounded' : '' }}">
            Posting Barang
        </a>
        <a href="/riwayat" class="block px-6 py-2 text-gray-700 hover:bg-gray-100 {{ request()->is('riwayat') ? 'bg-slate-900 text-white rounded' : '' }}">
            Riwayat Posting
        </a>
        <a href="/logout" class="block px-6 py-2 text-gray-700 hover:bg-gray-100">
            Logout
        </a>
    </nav>
</aside>
