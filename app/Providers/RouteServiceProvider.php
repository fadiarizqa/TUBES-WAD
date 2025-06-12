<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route; // Pastikan ini di-import

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home'; // Sesuaikan jika berbeda

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        parent::boot();

        $this->routes(function () {
            $apiPath = base_path('routes/api.php');
            // Route::middleware('api')
            //     ->prefix('api')
            //     ->group(base_path('routes/api.php'));
            Route::middleware('api')
            ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}