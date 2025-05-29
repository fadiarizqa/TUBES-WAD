@extends('layouts.app')

@section('page_title', 'Posting Barang Hilang')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800" style="
        color: #000;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-style: normal;
        font-weight: 600;
        line-height: 120%;
        letter-spacing: -0.56px;
    ">Form Posting Barang Hilang</h1>

    <form action="{{ route('lost_items.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-x-6 gap-y-4">
        @csrf

        <div class="flex flex-col gap-y-4 md:w-1/2">
            <div class="form-group">
                <label for="posting_type" class="form-label-font-compact">Jenis Posting</label>
                <select name="posting_type" id="posting_type" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 custom-input-style">
                    <option value="Barang Hilang" {{ old('posting_type', 'Barang Hilang') == 'Barang Hilang' ? 'selected' : '' }}>Barang Hilang</option>
                </select>
                @error('posting_type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="full_name" class="form-label-font-compact">Nama Lengkap</label>
                <input type="text" name="full_name" id="full_name" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 custom-input-style" value="{{ old('full_name') }}">
                @error('full_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="lost_item_name" class="form-label-font-compact">Nama Barang Hilang</label>
                <input type="text" name="lost_item_name" id="lost_item_name" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 custom-input-style" value="{{ old('lost_item_name') }}">
                @error('lost_item_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="item_type" class="form-label-font-compact">Jenis Barang</label>
                <select name="item_type" id="item_type" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 custom-input-style">
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
                <label for="item_description" class="form-label-font-compact">Deskripsi Barang</label>
                <textarea name="item_description" id="item_description" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 custom-input-style custom-textarea-height">{{ old('item_description') }}</textarea>
                @error('item_description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="lost_location" class="form-label-font-compact">Lokasi Kehilangan</label>
                <input type="text" name="lost_location" id="lost_location" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 custom-input-style" value="{{ old('lost_location') }}">
                @error('lost_location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="lost_date" class="form-label-font-compact">Tanggal Kehilangan</label>
                <input type="date" name="lost_date" id="lost_date" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-ring-indigo-200 focus:ring-opacity-50 custom-input-style" value="{{ old('lost_date') }}">
                @error('lost_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-col gap-y-4 md:w-1/2">
            <div class="form-group">
                <label for="phone_number" class="form-label-font-compact">No Telepon</label>
                <input type="text" name="phone_number" id="phone_number" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 custom-input-style" value="{{ old('phone_number') }}">
                @error('phone_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="social_media" class="form-label-font-compact">Social Media</label>
                <input type="text" name="social_media" id="social_media" class="block w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 custom-input-style" value="{{ old('social_media') }}">
                @error('social_media')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="item_photo" class="form-label-font-compact">Upload Foto Barang (jika ada)</label>
                <input type="file" name="item_photo" id="item_photo" class="block w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 custom-input-style custom-file-input-dimensions">
                @error('item_photo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Posting Barang Hilang</button>
            </div>
        </div>

    </form>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
    
    .custom-input-style {
        width: 100%;
        height: 41px; /* Keep a consistent height for most inputs */
        border-radius: 8px;
        border: 1px solid #080F2B;
        color: #000;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: 120%; /* Set a comfortable line height for all inputs */
        letter-spacing: -0.32px;
        padding: 0.75rem; /* Adjusted padding */
        box-sizing: border-box;
    }

    /* Specific styles for select elements */
    select.custom-input-style {
        height: auto; /* Allow height to adjust based on content and padding */
        min-height: 41px; /* Ensure a minimum height similar to other inputs */
        padding-top: 0.65rem; /* Increase top padding slightly */
        padding-bottom: 0.65rem; /* Increase bottom padding slightly */
        padding-right: 2.5rem; /* Ensure enough space for the arrow */
        background-position: right 0.75rem center;
        background-size: 1.5rem 1.5rem;
        font-size: 15px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22%23000%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E');
        background-repeat: no-repeat;
    }

    textarea.custom-input-style {
        height: 104px;
        resize: vertical;
        line-height: 1.5;
        overflow: auto;
    }

    .custom-textarea-height {
        height: 220px;
    }

    input[type="file"].custom-input-style {
        background-image: none;
        padding-right: 0.75rem;
        padding-left: 0.75rem;
    }

    .custom-file-input-dimensions {
        width: 540px;
        height: 220px;
        display: flex;
        align-items: center;
    }

    .form-label-font {
        color: #080F2B;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 20px;
        font-style: normal;
        font-weight: 600;
        line-height: 30px;
        letter-spacing: 0.06px;
    }

    .form-label-font-compact {
        color: #080F2B;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 20px;
        font-style: normal;
        font-weight: 600;
        line-height: 30px;
        letter-spacing: 0.06px;
        margin-bottom: 0.25rem;
        display: block;
    }

    .btn-primary {
        background-color: #080F2B;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
        display: inline-block;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 16px;
    }
    .btn-primary:hover {
        background-color: #1a233b;
    }

    @media (max-width: 768px) {
        form.flex-col {
            flex-direction: column;
        }
        form > div.md:w-1 {
            width: 100%;
        }

        .custom-input-style, .custom-file-input-dimensions {
            width: 100%;
        }
        .custom-textarea-height, .custom-file-input-dimensions {
            height: auto;
        }

        .custom-input-style {
            font-size: 14px;
            padding: 0.5rem;
        }
        select.custom-input-style {
            font-size: 13px;
            padding-top: 0.5rem; /* Adjusted for mobile */
            padding-bottom: 0.5rem; /* Adjusted for mobile */
            padding-right: 2.5rem;
            background-position: right 0.5rem center;
        }
        .form-label-font, .form-label-font-compact {
            font-size: 18px;
            line-height: 26px;
        }
        .btn-primary {
            padding: 0.6rem 1.2rem;
            font-size: 14px;
        }
    }
</style>
@endsection