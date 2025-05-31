<div class="max-w-xs bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
    <div class=" rounded-t-xl"></div>
        <img src="{{ asset('kimi.png') }}" alt="Logo"/>
    <div class="p-4">
        <h2 class="text-lg font-bold text-black">Nama Barang</h2>
        <!-- buat p ini nanti nerima sebuah deskripsi singkat aja dari si barang  -->
        <p class="text-sm text-gray-500 mt-1">
            Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet
        </p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <!-- routenya blm bener -->
            <button class="w-full text-black border-2 border-[#0F1123] text-sm mt-4 p-2 rounded-full hover:bg-[#0F1123] hover:!text-white cursor-pointer font-medium transition-colors duration-200">
                Lihat Detail Barang
            </button>
        </form>
        
    </div>
</div>