<?php

namespace App\Providers;
use App\Models\LostItem;
use App\Models\FoundedItem;
use App\Policies\LostItemPolicy;
use App\Policies\FoundedItemPolicy;
use App\Models\Comment;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected $policies = [
    'App\Models\FoundedItems' => 'App\Policies\FoundedItemPolicy',
    'App\Models\LostItems' => 'App\Policies\LostItemPolicy', 
];

}
