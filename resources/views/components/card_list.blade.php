<div class="w-full bg-white border border-gray-200 overflow-hidden shadow-sm">
    <div class="flex justify-end mb-4">
        <div class="inline-flex overflow-hidden">
            <button class="px-4 py-1 bg-gray-800 text-white cursor-pointer">Semua</button>
            <button class="px-4 py-1 hover:bg-gray-200 cursor-pointer">Barang ditemukan</button>
            <button class="px-4 py-1 hover:bg-gray-200 cursor-pointer">Barang hilang</button>
        </div>
    </div>
    <div class="bg-white rounded shadow overflow-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="p-3"><input type="checkbox" /></th>
                    <th class="p-3">Judul</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Deskripsi Barang</th>
                    <th class="p-3">Jenis Laporan</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 10; $i++)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3"><input type="checkbox" /></td>
                    <td class="p-3">
                        <div class="font-semibold">Lorem ipsum</div>
                        <div class="text-gray-500 text-xs">Lorem ipsum</div>
                    </td>
                    <td class="p-3 text-sm">
                        Jul 19, 2023<br />
                        <span class="text-gray-500 text-xs">06.42 AM</span>
                    </td>
                    <td class="p-3">Lorem ipsum</td>
                    <td class="p-3">Lorem ipsum</td>
                    <td class="p-3">
                        <button class="border px-3 py-1 rounded hover:bg-gray-100">Lorem ipsum</button>
                    </td>
                    <td class="p-3">
                        <button class="text-red-500 hover:text-red-700">
                            🗑️
                        </button>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>