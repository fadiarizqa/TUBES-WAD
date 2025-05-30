<!DOCTYPE html>
<html>
<head>
    <title>Carikeun</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="flex-layout">
        @include('components.sidebar')

        <div class="main-content">
            @include('components.navbar')

            <div class="p-6">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
