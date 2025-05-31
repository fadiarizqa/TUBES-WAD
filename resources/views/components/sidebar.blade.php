<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carikeun</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="sidebar">
    <div class="sidebar-items">
        <h2 class="text-xl font-bold mb-4">Carikeun</h2>
        
        <ul>
            <li><a href="{{ url('/home') }}" class="sidebar-item">Beranda</a></li>
            <li><a href="{{ url('/founded_items/create') }}" class="sidebar-item">Posting Barang</a></li>
            <li><a href="{{ url('/riwayat-posting') }}" class="sidebar-item">Riwayat Posting</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</div>

<div class="main-content">
    <div class="content-wrapper fade-in">
        <!-- Konten Anda di sini -->
    </div>
</div>
