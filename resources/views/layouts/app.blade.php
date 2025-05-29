<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Carikeun App - @yield('page_title', 'Page Title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
        }

        /* --- Sidebar Item Styles --- */
        .sidebar-item {
            display: flex;
            padding: 12px 20px;
            align-items: center;
            gap: 12px;
            align-self: stretch;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #374151;
            text-decoration: none;
            margin: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 14px;
            line-height: 22px;
            letter-spacing: 0.042px;
        }

        .sidebar-item:hover {
            background-color: #f3f4f6;
            color: #1f2937;
        }
        .sidebar-item.active {
            background-color: #080F2B;
            color: #FFF;
            font-weight: 500;
            box-shadow: 0 2px 4px -1px rgba(59, 130, 246, 0.4);
        }
        .sidebar-item.active:hover {
            background-color: #080F2B;
        }

        /* --- Form Group Focus Styles --- */
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #080F2B;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
        }

        /* --- Primary Button Hover Style --- */
        .btn-primary:hover {
            background-color: #080F2B;
        }

        /* --- Main Content Area Padding to clear fixed header --- */
        .main-content-area {
            padding-top: 5.5rem; /* Menyesuaikan tinggi header fixed */
        }
    </style>
</head>
<body class="flex bg-gray-100">
    <div class="w-64 bg-white text-gray-700 h-screen fixed top-0 left-0 z-30 border-r border-gray-200 flex flex-col">
        {{-- PERBAIKAN DI SINI: flex justify-center untuk menengahkan teks --}}
        {{-- Untuk menyelaraskan border, kita perlu memastikan tinggi bar header di sidebar dan di konten utama sama --}}
        <h1 class="h-24 px-6 py-7 border-b border-gray-200 bg-white text-gray-800 text-2xl font-bold flex items-center justify-center">Carikeun</h1>
        <nav class="mt-4 flex-grow flex flex-col justify-between">
            <ul class="list-none p-0 m-0 flex flex-col flex-grow">
                <li>
                    <a href="{{ url('/dashboard') }}" class="sidebar-item {{ Request::is('dashboard') || Request::is('/') ? 'active' : '' }}">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('lost_items.create') }}" class="sidebar-item {{ request()->routeIs('lost_items.create') ? 'active' : '' }}">
                        Posting Barang
                    </a>
                </li>
                <li>
                    <a href="{{ route('lost_items.index') }}" class="sidebar-item {{ request()->routeIs('lost_items.index') ? 'active' : '' }}">
                        Riwayat Posting
                    </a>
                </li>
                <li class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ url('/logout') }}" class="sidebar-item">
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="ml-64 flex-grow flex flex-col min-h-screen">
        {{-- PERBAIKAN DI SINI: Menambahkan tinggi tetap pada header untuk menyelaraskan border bawah --}}
        <header class="h-24 bg-white px-8 py-6 border-b border-gray-200 flex justify-between items-center z-40 fixed top-0 right-0" style="left: 256px;">
            <h2 class="text-xl font-semibold leading-8 tracking-wide text-gray-900">@yield('page_title', 'Page Title')</h2>
            <div class="flex items-center space-x-2">
                <span class="text-gray-700 font-semibold">Lala Khairunnisa</span>
                <div class="flex w-11 h-11 p-3 justify-center items-center rounded-full flex-shrink-0 bg-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" class="w-5 h-5 flex-shrink-0">
                        <path d="M5.48131 12.9013C4.30234 13.6033 1.21114 15.0367 3.09389 16.8305C4.01359 17.7067 5.03791 18.3333 6.32573 18.3333H13.6743C14.9621 18.3333 15.9864 17.7067 16.9061 16.8305C18.7888 15.0367 15.6977 13.6033 14.5187 12.9013C11.754 11.2551 8.24599 11.2551 5.48131 12.9013Z" fill="white" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.75 5.41667C13.75 7.48773 12.0711 9.16667 10 9.16667C7.92893 9.16667 6.25 7.48773 6.25 5.41667C6.25 3.3456 7.92893 1.66667 10 1.66667C12.0711 1.66667 13.75 3.3456 13.75 5.41667Z" fill="white" stroke="white" stroke-width="1.5"/>
                    </svg>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M16.6922 7.94219L10.4422 14.1922C10.3841 14.2503 10.3152 14.2964 10.2393 14.3279C10.1635 14.3593 10.0821 14.3755 10 14.3755C9.91787 14.3755 9.83654 14.3593 9.76067 14.3279C9.68479 14.2964 9.61586 14.2503 9.55782 14.1922L3.30782 7.94219C3.22031 7.85478 3.1607 7.74337 3.13655 7.62207C3.11239 7.50076 3.12477 7.37502 3.17211 7.26076C3.21946 7.14649 3.29964 7.04884 3.40252 6.98017C3.50539 6.91151 3.62632 6.8749 3.75 6.875H16.25C16.3737 6.8749 16.4946 6.91151 16.5975 6.98017C16.7004 7.04884 16.7805 7.14649 16.8279 7.26076C16.8752 7.37502 16.8876 7.50076 16.8635 7.62207C16.8393 7.74337 16.7797 7.85478 16.6922 7.94219Z" fill="#080F2B"/>
                </svg>
            </div>
        </header>

        <main class="flex-grow p-0 bg-gray-100 main-content-area">
            @if (session('success'))
                <div class="p-4 rounded-lg mb-4 flex items-center justify-between relative border bg-green-100 border-green-400 text-green-800" role="alert">
                    <div>
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    <span class="absolute top-2 right-2 cursor-pointer" onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 1.697L10 11.819l-2.651 2.652a1.2 1.2 0 1 1-1.697-1.697L8.303 10l-2.651-2.651a1.2 1.2 0 0 1 1.697-1.697L10 8.183l2.651-2.652a1.2 1.2 0 1 1 1.697 1.697L11.697 10l2.651 2.651z"/></svg>
                    </span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-lg mb-4 flex items-center justify-between relative border bg-red-100 border-red-400 text-red-800" role="alert">
                    <div>
                        <strong class="font-bold">Terjadi Kesalahan!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <span class="absolute top-2 right-2 cursor-pointer" onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 1.697L10 11.819l-2.651 2.652a1.2 1.2 0 1 1-1.697-1.697L8.303 10l-2.651-2.651a1.2 1.2 0 0 1 1.697-1.697L10 8.183l2.651-2.652a1.2 1.2 0 1 1 1.697 1.697L11.697 10l2.651 2.651z"/></svg>
                    </span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>