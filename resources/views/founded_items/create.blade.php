@extends('layouts.app')

@section('page_title', 'Form Posting Barang Ditemukan')

@section('content')
<div class="min-h-screen flex">

    {{-- Main content --}}
    <main class="flex-1 p-10 bg-white">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Form Posting Barang Ditemukan</h1>
            <div class="flex items-center gap-2">
                <span>{{ Auth::user()->name ?? 'User' }}</span>
                <div class="w-8 h-8 bg-slate-900 rounded-full flex items-center justify-center text-white">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>

        <form action="{{ route('founded_items.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-6">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Jenis Posting</label>
                <select name="jenis_posting" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="barang_ditemukan">Barang Ditemukan</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">No Telepon</label>
                <input type="text" name="telepon" class="w-full border border-gray-300 rounded px-3 py-2" required />
            </div>

            <div>
                <label class="block mb-1 font-medium">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="w-full border border-gray-300 rounded px-3 py-2" required />
            </div>

            <div>
                <label class="block mb-1 font-medium">Sosial Media</label>
                <input type="text" name="sosial_media" class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>

            <div>
                <label class="block mb-1 font-medium">Nama Barang Ditemukan</label>
                <input type="text" name="nama_barang" class="w-full border border-gray-300 rounded px-3 py-2" required />
            </div>

            <div>
                <label class="block mb-1 font-medium">Upload Foto Barang (jika ada)</label>
                <input type="file" name="foto_barang" class="w-full border border-gray-300 rounded px-3 py-2" accept="image/*" />
            </div>

            <div>
                <label class="block mb-1 font-medium">Jenis Barang</label>
                <select name="jenis_barang" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="ktm">KTM</option>
                    <option value="ktp">KTP</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Deskripsi Barang</label>
                <textarea name="deskripsi" class="w-full border border-gray-300 rounded px-3 py-2 h-28 resize-none"></textarea>
            </div>

            <div>
                <label class="block mb-1 font-medium">Lokasi Penemuan</label>
                <input type="text" name="lokasi" class="w-full border border-gray-300 rounded px-3 py-2" required />
            </div>

            <div>
                <label class="block mb-1 font-medium">Tanggal Penemuan</label>
                <input type="date" name="tanggal" class="w-full border border-gray-300 rounded px-3 py-2" required />
            </div>

            <div class="col-span-2 text-right">
                <button type="submit" class="bg-slate-900 text-white px-6 py-2 rounded w-full sm:w-auto">
                    Posting Barang Ditemukan
                </button>
            </div>
        </form>
    </main>
</div>
@endsection
