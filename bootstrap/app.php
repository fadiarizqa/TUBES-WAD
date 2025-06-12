<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        api: __DIR__.'/../routes/api.php', // Ini akan memuat routes/api.php
        apiPrefix: 'api', // Prefix default tetap 'api'
    )
    ->withMiddleware(function (Middleware $middleware) {
        // =================================================================
        // DAFTARKAN ALIAS MIDDLEWARE ANDA DI SINI
        // Ini adalah pengganti dari Kernel.php di Laravel 11
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
        // =================================================================
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
