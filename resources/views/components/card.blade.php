@props(['nama', 'deskripsi', 'foto', 'id', 'type'])
<div class="w-[270px] bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm flex flex-col justify-between">
    <div class=" rounded-t-xl"></div>
        <img class="w-full h-[160px] object-cover rounded-t-lg" src="{{ asset('storage/' . $foto) }}" alt="Foto Barang">
    <div class="p-4">
        <h2 class="text-lg font-bold text-black">{{ $nama }}</h2>
        <!-- buat p ini nanti nerima sebuah deskripsi singkat aja dari si barang  -->
        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($deskripsi, 50) }}</p>
        <!-- routing ke detail barangnya -->        
        <a href="{{ $type == 'founded' ? route('founded_items.show', $id) : route('lost_items.show', $id) }}"
           class="w-full text-black border-2 border-[#0F1123] text-sm mt-4 p-2 rounded-full hover:bg-[#0F1123] hover:text-white cursor-pointer font-medium transition-colors duration-200 inline-block text-center">
           Lihat Detail Barang
        </a>
        
    </div>
</div>