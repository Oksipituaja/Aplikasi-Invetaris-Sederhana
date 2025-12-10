<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema; // Opsional: untuk default string length

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
        // FIX: Memaksa skema HTTPS di environment production/staging
        if (App::environment('production') || str_contains(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
        
        // Opsional: Mengatur default string length jika Anda mengalami error "Specified key was too long"
        // Schema::defaultStringLength(191); 
    }
}
