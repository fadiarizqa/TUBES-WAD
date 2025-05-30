@extends('layouts.auth')

@section('content')

<body>
    <div class="form-login-wrapper">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            @if ($errors->any())
                <div style="color:red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-container">
                <div class="header-text">Register Akun</div>
                <div class="form-group">
                    <label class="form-label" for="name">Username</label>
                    <input id="name" name="name" type="text" class="input-field" placeholder="Masukkan username" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" name="email" type="email" class="input-field" placeholder="Masukkan email" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input id="password" name="password" type="password" class="input-field" placeholder="Masukkan password" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="input-field" placeholder="Ulangi password" required>
                </div>

                <div style="margin-top: 10px; text-align: center;">
                <span>Sudah punya akun? <a href="{{ route('login') }}" style="color: blue; text-decoration: underline;">Masuk di sini</a></span>
                </div>

                <button type="submit" class="button-submit">Register Akun</button>
            </div>
        </form>    
    </div>
</body>

@endsection
