@extends('layouts.app')

@section('content')
@if(session('error') || session('success'))
    @php
        $type = session('error') ? 'error' : 'success';
        $message = session($type);
        $bgColor = $type === 'error' ? 'bg-red-500' : 'bg-green-500';
        $id = $type . 'Message';
        $closeFunction = 'close' . ucfirst($type) . 'Message';
    @endphp

    <div id="{{ $id }}" class="{{ $bgColor }} text-white p-4 rounded-lg mb-6 relative">
        <span>{{ $message }}</span>
        <button class="absolute right-5 text-white font-bold" onclick="{{ $closeFunction }}()">X</button>
    </div>

    <script>
        function {{ $closeFunction }}() {
            document.getElementById('{{ $id }}').classList.add('hidden');
        }

        setTimeout(function() {
            var el = document.getElementById('{{ $id }}');
            if (el) el.classList.add('hidden');
        }, 5000);
    </script>
@endif

<body>
    <div class="form-login-wrapper">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-container">
                <div class="header-text">Masuk Akun</div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" class="input-field" placeholder="Masukkan email">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input id="password" type="password" class="input-field" placeholder="Masukkan password">
                </div>
                
                <div style="margin-top: 10px; text-align: center;">
                <span>Belum punya akun? <a href="{{ route('register') }}" style="color: blue; text-decoration: underline;">Daftar di sini</a></span>
                </div>

                <button type="submit" class="button-submit">Masuk Akun</button>
            </div>
        </form>
    </div>
</body>


@endsection
