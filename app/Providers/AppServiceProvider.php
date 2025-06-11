<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

use App\Models\FoundedItem;
use App\Models\LostItem;
use App\Policies\LostItemPolicy;
use App\Policies\FoundedItemPolicy;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'found' => FoundedItem::class, 
            'lost'  => LostItem::class,    
        ]);
    }

    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Comment' => 'App\Policies\CommentPolicy', // <-- Tambahkan ini
        
    ];
}
