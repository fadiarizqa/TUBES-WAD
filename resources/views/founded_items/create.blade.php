@extends('layouts.app')

@section('page_title', 'Form Posting Barang Ditemukan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800" style="
        color: #000;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-style: normal;
        font-weight: 600;
        line-height: 120%;  
        letter-spacing: -0.56px;
    ">Form Posting Barang Ditemukan</h1>

    <form action="{{ route('founded_items.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-x-6 gap-y-4">
        @csrf

        <div class="flex flex-col gap-y-4 md:w-1/2">
            <div class="form-group">
                <label for="posting_type" style="color: #080F2B; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-style: normal; font-weight: 600; line-height: 30px; letter-spacing: 0.06px; margin-bottom: 0.25rem; display: block;">Jenis Posting</label>
                <select name="posting_type" id="posting_type" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="width: 100%; height: auto; min-height: 41px; border-radius: 8px; border: 1px solid #080F2B; color: #252525; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 120%; letter-spacing: -0.28px; padding: 0.65rem 2.5rem 0.65rem 0.75rem; box-sizing: border-box; -webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%23000%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1.5rem 1.5rem;">
                        <option value="Barang Hilang" {{ old('posting_type', 'Barang Hilang') == 'Barang Hilang' ? 'selected' : '' }}>Barang Hilang</option>
                        <option value="Barang Ditemukan" {{ old('posting_type', 'Barang Ditemukan') == 'Barang Ditemukan' ? 'selected' : '' }}>Barang Ditemukan</option>
                </select>
                @error('posting_type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="full_name" style="color: #080F2B; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-style: normal; font-weight: 600; line-height: 30px; letter-spacing: 0.06px; margin-bottom: 0.25rem; display: block;">Nama Lengkap</label>
                <input type="text" name="full_name" id="full_name" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="width: 100%; height: 41px; border-radius: 8px; border: 1px solid #080F2B; color: #000; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-style: normal; font-weight: 500; line-height: 120%; letter-spacing: -0.32px; padding: 0.75rem; box-sizing: border-box;" value="{{ old('full_name') }}">
                @error('full_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="found_item_name" style="color: #080F2B; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-style: normal; font-weight: 600; line-height: 30px; letter-spacing: 0.06px; margin-bottom: 0.25rem; display: block;">Nama Barang Ditemukan</label>
                <input type="text" name="found_item_name" id="found_item_name" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="width: 100%; height: 41px; border-radius: 8px; border: 1px solid #080F2B; color: #000; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-style: normal; font-weight: 500; line-height: 120%; letter-spacing: -0.32px; padding: 0.75rem; box-sizing: border-box;" value="{{ old('found_item_name') }}">
                @error('found_item_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="item_type" style="color: #080F2B; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-style: normal; font-weight: 600; line-height: 30px; letter-spacing: 0.06px; margin-bottom: 0.25rem; display: block;">Jenis Barang</label>
                <select name="item_type" id="item_type" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="width: 100%; height: auto; min-height: 41px; border-radius: 8px; border: 1px solid #080F2B; color: #252525; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 120%; letter-spacing: -0.28px; padding: 0.65rem 2.5rem 0.65rem 0.75rem; box-sizing: border-box; -webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%23000%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1.5rem 1.5rem;">
                        <option value="">Pilih Jenis Barang</option>
                        <option value="KTP" {{ old('item_type') == 'KTP' ? 'selected' : '' }}>KTP</option>
                        <option value="SIM" {{ old('item_type') == 'SIM' ? 'selected' : '' }}>SIM</option>
                        <option value="Dompet" {{ old('item_type') == 'Dompet' ? 'selected' : '' }}>Dompet</option>
                        <option value="HP" {{ old('item_type') == 'HP' ? 'selected' : '' }}>HP</option>
                        <option value="Tas" {{ old('item_type') == 'Tas' ? 'selected' : '' }}>Tas</option>
                        <option value="Dokumen Penting" {{ old('item_type') == 'Dokumen Penting' ? 'selected' : '' }}>Dokumen Penting</option>
                        <option value="Lainnya" {{ old('item_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('item_type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="item_description" style="color: #080F2B; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-style: normal; font-weight: 600; line-height: 30px; letter-spacing: 0.06px; margin-bottom: 0.25rem; display: block;">Deskripsi Barang</label>
                <textarea name="item_description" id="item_description" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="width: 100%; height: 220px; border-radius: 8px; border: 1px solid #080F2B; color: #252525; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 120%; letter-spacing: -0.28px; padding: 0.75rem; box-sizing: border-box; resize: vertical; overflow: auto;">{{ old('item_description') }}</textarea>
                @error('item_description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="found_location" style="color: #080F2B; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-style: normal; font-weight: 600; line-height: 30px; letter-spacing: 0.06px; margin-bottom: 0.25rem; display: block;">Lokasi Penemuan</label>
                <input type="text" name="found_location" id="found_location" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="width: 100%; height: 41px; border-radius: 8px; border: 1px solid #080F2B; color: #000; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-style: normal; font-weight: 500; line-height: 120%; letter-spacing: -0.32px; padding: 0.75rem; box-sizing: border-box;" value="{{ old('found_location') }}">
                @error('found_location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="found_date" style="color: #080F2B; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-style: normal; font-weight: 600; line-height: 30px; letter-spacing: 0.06px; margin-bottom: 0.25rem; display: block;">Tanggal Penemuan</label>
                <input type="date" name="found_date" id="found_date" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-ring-indigo-200 focus:ring-opacity-50" style="width: 100%; height: 41px; border-radius: 8px; border: 1px solid #080F2B; color: #000; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-style: normal; font-weight: 500; line-height: 120%; letter-spacing: -0.32px; padding: 0.75rem; box-sizing: border-box;" value="{{ old('found_date') }}">
                @error('found_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-col gap-y-4 md:w-1/2">
            <div class="form-group">
                <label for="phone_number" style="color: #080F2B; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-style: normal; font-weight: 600; line-height: 30px; letter-spacing: 0.06px; margin-bottom: 0.25rem; display: block;">No Telepon</label>
                <input type="text" name="phone_number" id="phone_number" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="width: 100%; height: 41px; border-radius: 8px; border: 1px solid #080F2B; color: #000; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-style: normal; font-weight: 500; line-height: 120%; letter-spacing: -0.32px; padding: 0.75rem; box-sizing: border-box;" value="{{ old('phone_number') }}">
                @error('phone_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="social_media" style="color: #080F2B; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-style: normal; font-weight: 600; line-height: 30px; letter-spacing: 0.06px; margin-bottom: 0.25rem; display: block;">Social Media</label>
                <input type="text" name="social_media" id="social_media" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="width: 100%; height: 41px; border-radius: 8px; border: 1px solid #080F2B; color: #000; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-style: normal; font-weight: 500; line-height: 120%; letter-spacing: -0.32px; padding: 0.75rem; box-sizing: border-box;" value="{{ old('social_media') }}">
                @error('social_media')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="item_photo" style="color: #080F2B; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-style: normal; font-weight: 600; line-height: 30px; letter-spacing: 0.06px; margin-bottom: 0.25rem; display: block;">Upload Foto Barang (jika ada)</label>
                {{-- Changed border-style from dashed to solid --}}
                <div style="position: relative; width: 100%; height: 150px; border: 2px solid #D1D5DB; border-radius: 12px; background-color: #F9FAFB; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center;" onmouseover="this.style.borderColor='#080F2B'; this.style.backgroundColor='#F3F4F6';" onmouseout="this.style.borderColor='#D1D5DB'; this.style.backgroundColor='#F9FAFB';">
                    <input type="file" name="item_photo" id="item_photo" accept="image/*" style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2;">
                    <div style="text-align: center; pointer-events: none; z-index: 1;">
                        <svg style="width: 32px; height: 32px; margin: 0 auto 8px; color: #6B7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <span style="display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 4px;">Klik untuk upload foto</span>
                        <span style="display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 400; color: #6B7280; margin-bottom: 4px;">atau drag & drop file di sini</span>
                        <span style="display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 400; color: #9CA3AF;">PNG, JPG, GIF up to 5MB</span>
                    </div>
                </div>
                @error('item_photo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                {{-- Button is now full width (w-full) and within the same form-group --}}
                <div class="mt-4">
                    <button type="submit" class="w-full" style="background-color: #080F2B; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; font-weight: bold; cursor: pointer; transition: background-color 0.3s ease; display: block; text-align: center; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; border: none;" onmouseover="this.style.backgroundColor='#1a233b';" onmouseout="this.style.backgroundColor='#080F2B';">Posting Barang Ditemukan</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('item_photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const container = this.parentElement;
    const textElement = container.querySelector('div:nth-child(2)');
    
    if (file) {
        textElement.innerHTML = `
            <svg style="width: 32px; height: 32px; margin: 0 auto 8px; color: #10B981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span style="display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 600; color: #065F46; margin-bottom: 4px;">File terpilih: ${file.name}</span>
            <span style="display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 400; color: #047857;">Klik untuk mengubah file</span>
        `;
        container.style.borderColor = '#10B981';
        container.style.backgroundColor = '#ECFDF5';
    } else {
        // Reset to initial state if no file is selected (e.g., user cancels selection)
        textElement.innerHTML = `
            <svg style="width: 32px; height: 32px; margin: 0 auto 8px; color: #6B7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <span style="display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 4px;">Klik untuk upload foto</span>
            <span style="display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 400; color: #6B7280; margin-bottom: 4px;">atau drag & drop file di sini</span>
            <span style="display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 400; color: #9CA3AF;">PNG, JPG, GIF up to 5MB</span>
        `;
        container.style.borderColor = '#D1D5DB';
        container.style.backgroundColor = '#F9FAFB';
    }
});
</script>
@endsection