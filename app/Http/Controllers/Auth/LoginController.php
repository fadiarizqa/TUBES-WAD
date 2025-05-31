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
        // if (Auth::check()) {
        //     return redirect()->route('home');
        // }
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ]);

        Log::info('Login attempt', ['email' => $credentials['email']]);

        if (Auth::attempt($credentials)) {
            Log::info('Login successful', ['email' => $credentials['email']]);
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Login berhasil!');
        }

        Log::warning('Login failed', ['email' => $credentials['email']]);
        
        return back()
            ->withInput()
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
    }

    public function logout(Request $request)
    {
        $email = Auth::user()->email; 
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('User logged out', ['email' => $email]);
        return redirect('/login')->with('success', 'Anda telah berhasil logout!');
    }
}