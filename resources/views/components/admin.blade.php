<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carikeun</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="sidebar fixed bg-white">
        <h2 class="flex justify-center text-xl font-bold mb-4 mt-2">Carikeun</h2>
        <ul class="flex flex-col gap-5">
            <li><a href="{{ url('/admin/home') }}" class="sidebar-item">Beranda</a></li>
            <li><a href="{{ url('/admin/reports') }}" class="sidebar-item">Report Postingan</a></li>
            <li><a href="{{ url('/admin/claims') }}" class="sidebar-item">Pengajuan Claim</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</body>
