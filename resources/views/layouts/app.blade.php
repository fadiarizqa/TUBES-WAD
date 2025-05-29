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
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            color: #374151;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            border-right: 1px solid #e2e8f0;
            display: flex; /* Make sidebar a flex container */
            flex-direction: column; /* Stack its content vertically */
        }
        .sidebar h1 {
            padding: 1.75rem 1.5rem;
            border-bottom: 1px solid #EEEEF0;
            background: #FFF;
            color: #1f2937;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            box-sizing: border-box;
        }
        .main-content-wrapper {
            margin-left: 250px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .sidebar nav {
            margin-top: 1rem;
            flex-grow: 1; /* Allows the nav to take up available space */
            display: flex; /* Make nav a flex container */
            flex-direction: column; /* Stack nav items vertically */
            justify-content: space-between; /* Pushes the last item (Logout) to the bottom */
        }
        .sidebar nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex; /* Make the ul a flex container */
            flex-direction: column; /* Stack list items vertically */
            flex-grow: 1; /* Allow the ul to take up available space within nav */
        }
        .sidebar-item {
            display: flex;
            padding: 12px 20px; /* Applied from your request */
            align-items: center;
            gap: 12.462px; /* Applied from your request */
            align-self: stretch; /* Applied from your request */

            cursor: pointer;
            transition: all 0.2s ease;
            color: #374151;
            text-decoration: none;
            margin: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px; /* Ensure consistent font size */
            line-height: 22px; /* Ensure consistent line height */
            letter-spacing: 0.042px; /* Ensure consistent letter spacing */
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
            /* These were already in your .active, just reiterating to keep them here for consistency */
            font-size: 14px;
            line-height: 22px;
            letter-spacing: 0.042px;
        }
        .sidebar-item.active:hover {
            background-color: #080F2B;
        }
        .content {
            flex-grow: 1;
            padding: 0;
            background-color: #f0f2f5;
        }
        .header {
            background-color: #fff;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            z-index: 5;
            margin-left: -250px;
            padding-left: calc(250px + 2rem);
        }
        .header h2 {
            color: #080F2B;
            font-family: "Plus Jakarta Sans";
            font-size: 20px;
            font-style: normal;
            font-weight: 600;
            line-height: 30px;
            letter-spacing: 0.06px;
            margin: 0;
        }
        .form-group label,
        .form-group input,
        .form-group select,
        .form-group textarea,
        .btn-primary,
        .alert {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #4a5568;
            font-size: 0.875rem;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #cbd5e0;
            border-radius: 0.375rem;
            font-size: 1rem;
            background-color: #f7fafc;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #080F2B;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
        }
        .btn-primary {
            background-color: #080F2B;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #080F2B;
        }
        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        .alert-success {
            background-color: #d1fae5;
            border-color: #34d399;
            color: #065f46;
        }
        .alert-error {
            background-color: #fee2e2;
            border-color: #f87171;
            color: #991b1b;
        }
        .alert-close-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            cursor: pointer;
        }
    </style>
</head>
<body class="flex">
    <div class="sidebar">
        <h1>Carikeun</h1>
        <nav>
            <ul>
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
                {{-- This <li> will be pushed to the bottom due to flex-grow and justify-content --}}
                <li>
                    <a href="{{ url('/logout') }}" class="sidebar-item">
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="main-content-wrapper">
        <header class="header">
            <h2>@yield('page_title', 'Page Title')</h2>
            <div class="flex items-center space-x-2">
                <span class="text-gray-700" style="font-family: 'Plus Jakarta Sans', sans-serif;">Lala Khairunnisa</span>
                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </header>

        <main class="content">
            @if (session('success'))
                <div class="alert alert-success border" role="alert">
                    <div>
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    <span class="alert-close-btn" onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 1.697L10 11.819l-2.651 2.652a1.2 1.2 0 1 1-1.697-1.697L8.303 10l-2.651-2.651a1.2 1.2 0 0 1 1.697-1.697L10 8.183l2.651-2.652a1.2 1.2 0 1 1 1.697 1.697L11.697 10l2.651 2.651z"/></svg>
                    </span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error border" role="alert">
                    <div>
                        <strong class="font-bold">Terjadi Kesalahan!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <span class="alert-close-btn" onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 1.697L10 11.819l-2.651 2.652a1.2 1.2 0 1 1-1.697-1.697L8.303 10l-2.651-2.651a1.2 1.2 0 0 1 1.697-1.697L10 8.183l2.651-2.652a1.2 1.2 0 1 1 1.697 1.697L11.697 10l2.651 2.651z"/></svg>
                    </span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>