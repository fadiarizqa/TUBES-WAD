@extends('layouts.auth')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100 relative">

    <div class="absolute top-8 w-full max-w-md px-4">
        @if (session('success'))
            <x-alert type="success" title="Berhasil" :message="session('success')" class="alert-box" />
        @elseif (session('error'))
            <x-alert type="error" title="Gagal" :message="session('error')" class="alert-box" />
        @endif

        @if ($errors->any())
            <x-alert type="error" title="Error" :message="$errors->first()" class="alert-box" />
        @endif
    </div>

    <div class="bg-white p-8 rounded-lg shadow-md w-[400px]">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <h2 class="text-2xl font-semibold text-center mb-6">Register Akun</h2>

            <div class="mb-4">
                <label for="name" class="block mb-1 font-medium">Username</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}"
                       placeholder="Masukkan username"
                       required
                       class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
            </div>

            <div class="mb-4">
                <label for="email" class="block mb-1 font-medium">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                       placeholder="Masukkan email"
                       required
                       class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
            </div>

            <div class="mb-4">
                <label for="password" class="block mb-1 font-medium">Password</label>
                <input id="password" name="password" type="password"
                       placeholder="Masukkan password"
                       required
                       class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block mb-1 font-medium">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                       placeholder="Ulangi password"
                       required
                       class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4 text-sm text-center">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 underline">Masuk di sini</a>
            </div>

            <button type="submit" class="w-full bg-[#0b1023] text-white font-semibold py-3 rounded-full hover:bg-[#0a0e1f] transition duration-300 cursor-pointer">
                Register Akun
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alertBox = document.querySelector('.alert-box');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.transition = 'opacity 0.5s ease';
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.remove(), 500);
            }, 3000); // 3 detik
        }
    });
</script>
@endsection
