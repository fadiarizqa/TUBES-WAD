<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Redirect jika sudah login
        // if (Auth::check()) {
        //     return redirect()->route('home');
        // }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        Log::info('Percobaan login', ['email' => $credentials['email']]);

        if (Auth::attempt($credentials)) {
            Log::info('Login berhasil', ['email' => $credentials['email']]);
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Login berhasil!');
        }

        Log::warning('Login gagal', ['email' => $credentials['email']]);

        return redirect()->back()
            ->withInput()
            ->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        $email = Auth::user()->email;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('Logout', ['email' => $email]);

        return redirect('/login')->with('success', 'Anda telah berhasil logout!');
    }
}
