<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Tambahkan pengecualian untuk rute login, register, dan halaman utama
        if ($request->routeIs('login' || $request->routeIs('register') || $request->is('/'))) {
            return $next($request);
        }

        // Jika belum login, redirect ke login dengan flash message
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melanjutkan!');
        }
        return $next($request);
    }
}
