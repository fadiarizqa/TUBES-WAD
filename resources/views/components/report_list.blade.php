@props(['reports'])

<div class="w-full bg-white border border-gray-200 overflow-hidden shadow-sm">
    <div class="bg-white rounded shadow overflow-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="p-3"><input type="checkbox" /></th>
                    <th class="p-3">Judul Postingan</th>
                    <th class="p-3">Pelapor</th>
                    <th class="p-3">Tanggal Laporan</th>
                    <th class="p-3">Alasan</th>
                    <th class="p-3">Jenis Laporan</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3"><input type="checkbox" /></td>
                    <td class="p-3">
                        @if ($report->post)
                            <div class="font-semibold">{{ $report->post->found_item_name ?? $report->post->lost_item_name }}</div>
                        @else
                            <div class="text-red-500">Postingan tidak ditemukan</div>
                        @endif
                    </td>
                    <td class="p-3">{{ $report->user->name }}</td>
                    <td class="p-3 text-sm">
                        {{ $report->created_at->format('d M Y') }}<br />
                        <span class="text-gray-500 text-xs">{{ $report->created_at->format('h.i A') }}</span>
                    </td>
                    <td class="p-3">{{ Str::limit($report->reason, 50) }}</td>
                    <td class="p-3">
                        @if ($report->post_type == \App\Models\FoundedItem::class)
                            Barang Ditemukan
                        @elseif ($report->post_type == \App\Models\LostItem::class)
                            Barang Hilang
                        @endif
                    </td>
                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full text-xs
                            @if($report->status == 'pending') bg-yellow-200 text-yellow-800
                            @elseif($report->status == 'reviewed') bg-green-200 text-green-800
                            @elseif($report->status == 'rejected') bg-red-200 text-red-800
                            @endif">
                            {{ ucfirst($report->status) }}
                        </span>
                    </td>
                    <td class="p-3">
                        {{-- Wadah untuk tombol aksi dengan tata letak vertikal --}}
                        <div class="flex flex-col items-start space-y-2">
                            <a href="{{ route('admin.reports.show', $report->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                Lihat
                            </a>
                            
                            @if ($report->status == 'reviewed' && $report->post)
                                <form action="{{ route('admin.reports.destroyPost', $report) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini secara permanen? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                        Hapus Postingan
                                    </button>
                                </form>
                            @endif

                            @if ($report->status == 'rejected')
                                <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                        Hapus Laporan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="p-3 text-center">Tidak ada laporan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>