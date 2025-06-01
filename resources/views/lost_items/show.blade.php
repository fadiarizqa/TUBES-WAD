@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">{{ $item->found_item_name }}</h1>
    <p><strong>Ditemukan di:</strong> {{ $item->lokasi_ditemukan }}</p>
    <p><strong>Deskripsi:</strong> {{ $item->item_description }}</p>
    <img src="{{ asset('storage/' . $item->item_photo) }}" alt="Foto Barang" class="w-full max-w-md rounded-lg mt-4">
    <a href="{{ route('founded_items.index') }}" class="text-blue-600 hover:underline mt-6 inline-block">← Kembali ke daftar barang ditemukan</a>
</div>
@endsection
