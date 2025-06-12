@php
    // Variabel ini dikirim dari ReportsController@create untuk menentukan konteks.
@endphp

@if ($isAdminContext)

<x-admin>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Tombol Kembali yang benar untuk admin, kembali ke halaman sebelumnya di panel --}}
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 mb-6 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 flex flex-col md:flex-row gap-8">
            {{-- KIRI: Preview Postingan --}}
            <div class="md:w-1/2 w-full">
                <h3 class="text-lg font-bold text-gray-800 mb-3">Preview Postingan</h3>
                @if ($item && $item->item_photo)
                    <img class="w-full h-[300px] object-cover rounded-lg border border-gray-200" src="{{ asset('storage/' . $item->item_photo) }}" alt="Foto Barang">
                @else
                    <div class="w-full h-[300px] bg-gray-200 flex items-center justify-center text-gray-500 rounded-lg">
                        Tidak ada foto
                    </div>
                @endif
                <div class="mt-4">
                    <h2 class="text-2xl font-bold text-black">{{ $item->lost_item_name ?? $item->found_item_name }}</h2>
                    <p class="text-gray-600 mt-2 text-sm">{{ Str::limit($item->item_description ?? '-', 150) }}</p>
                </div>
            </div>

            {{-- KANAN: Form Laporan --}}
            <div class="md:w-1/2 w-full flex flex-col">
                <h3 class="text-lg font-bold text-gray-800 mb-3">Alasan Pelaporan</h3>
                <form action="{{ route('reports.store') }}" method="POST" class="flex flex-col flex-grow">
                    @csrf
                    <input type="hidden" name="reportable_id" value="{{ $item_id }}">
                    <input type="hidden" name="reportable_type" value="{{ $item_type }}">
                    <input type="hidden" name="from_admin" value="1">

                    <div class="flex-grow">
                        <label for="alasan" class="sr-only">Alasan Pelaporan</label>
                        <textarea name="alasan" id="alasan" rows="8" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Jelaskan mengapa Anda melaporkan postingan ini...">{{ old('alasan') }}</textarea>
                        @error('alasan')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-danger">Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin>


{{-- ====================================================================== --}}
{{--              JIKA YANG MENGAKSES ADALAH PENGGUNA BIASA                 --}}
{{-- ====================================================================== --}}
@else

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laporkan Postingan</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="flex">
            <x-sidebar/>
            <div class="main-content w-full p-4 ml-[300px]">
                <div class="header flex justify-between items-center">
                    <h1 class="text-xl font-semibold">Laporkan Postingan</h1>
                    <div class="profile flex gap-5 items-center">
                        <p>{{ Auth::user()->name }}</p>
                        <img src="{{ Auth::user()->foto_profil_url }}" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover border">
                    </div>
                </div>

                <div class="mt-4 bg-white border border-gray-200 rounded-xl shadow-sm p-6 flex flex-col md:flex-row gap-8">
                    {{-- KIRI: Preview Postingan --}}
                    <div class="md:w-1/2 w-full">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">Preview Postingan</h3>
                        @if ($item && $item->item_photo)
                            <img class="w-full h-[300px] object-cover rounded-lg border border-gray-200" src="{{ asset('storage/' . $item->item_photo) }}" alt="Foto Barang">
                        @else
                            <div class="w-full h-[300px] bg-gray-200 flex items-center justify-center text-gray-500 rounded-lg">
                                Tidak ada foto
                            </div>
                        @endif
                        <div class="mt-4">
                            <h2 class="text-2xl font-bold text-black">{{ $item->lost_item_name ?? $item->found_item_name }}</h2>
                            <p class="text-gray-600 mt-2 text-sm">{{ Str::limit($item->item_description ?? '-', 150) }}</p>
                        </div>
                    </div>

                    {{-- KANAN: Form Laporan --}}
                    <div class="md:w-1/2 w-full">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">Alasan Pelaporan</h3>
                        <form action="{{ route('reports.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="reportable_id" value="{{ $item_id }}">
                            <input type="hidden" name="reportable_type" value="{{ $item_type }}">

                            <div>
                                <label for="alasan" class="sr-only">Alasan Pelaporan</label>
                                <textarea name="alasan" id="alasan" rows="8" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Jelaskan mengapa Anda melaporkan postingan ini...">{{ old('alasan') }}</textarea>
                                @error('alasan')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end gap-3">
                                <a href="{{ route('home') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-danger">Kirim Laporan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @php
        $popupType = session('success') ? 'success' : (session('error') ? 'error' : '');
        $popupMessage = session('success') ?? session('error');
    @endphp

    @if ($popupType && $popupMessage)
        <div id="popup-modal"
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300 opacity-0"
             data-popup-type="{{ $popupType }}"
             data-popup-message="{{ $popupMessage }}">
            
            <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md mx-4 text-center transform transition-transform duration-300 scale-95">
                <div id="popup-icon" class="mx-auto flex items-center justify-center h-12 w-12 rounded-full mb-4"></div>
                <h3 id="popup-title" class="text-xl font-bold text-gray-900"></h3>
                <p id="popup-message" class="text-sm text-gray-600 mt-2"></p>
                <div class="mt-6">
                    <button id="popup-ok" class="w-full px-4 py-2 rounded-md font-semibold text-white shadow-sm transition-colors">OK</button>
                </div>
            </div>
        </div>
    @endif

        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('popup-modal');
            
            // Script hanya berjalan jika elemen modal ada di halaman
            if (modal) {
                const modalContent = modal.querySelector('.transform');
                const okButton = document.getElementById('popup-ok');
                const title = document.getElementById('popup-title');
                const messageElement = document.getElementById('popup-message');
                const iconContainer = document.getElementById('popup-icon');

                // Ambil data dari atribut data-*
                const popupType = modal.dataset.popupType;
                const popupMessage = modal.dataset.popupMessage;
                const homeUrl = "{{ route('home') }}";

                if (popupType === 'success') {
                    title.textContent = 'Laporan Terkirim';
                    iconContainer.innerHTML = `<svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`;
                    iconContainer.className = 'mx-auto flex items-center justify-center h-12 w-12 rounded-full mb-4 bg-green-100';
                    okButton.className = 'w-full px-4 py-2 rounded-md font-semibold text-white shadow-sm transition-colors bg-green-600 hover:bg-green-700';
                } else if (popupType === 'error') {
                    title.textContent = 'Gagal Mengirim Laporan';
                    iconContainer.innerHTML = `<svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>`;
                    iconContainer.className = 'mx-auto flex items-center justify-center h-12 w-12 rounded-full mb-4 bg-red-100';
                    okButton.className = 'w-full px-4 py-2 rounded-md font-semibold text-white shadow-sm transition-colors bg-red-600 hover:bg-red-700';
                }

                messageElement.textContent = popupMessage;
                
                // Tampilkan modal dengan animasi
                modal.classList.remove('opacity-0');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95');
                }, 10);

                // Arahkan ke home ketika tombol OK ditekan
                okButton.addEventListener('click', function() {
                    window.location.href = homeUrl;
                });
            }
        });
        </script>

</body>
</html>

@endif