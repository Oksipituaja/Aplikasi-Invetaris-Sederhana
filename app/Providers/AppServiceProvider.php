<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Import Facade URL
use Illuminate\Support\Facades\App; // Import Facade App (opsional, untuk cek environment)

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
        // FIX: Memaksa Laravel menggunakan skema HTTPS untuk semua URL
        // Ini mengatasi masalah "Mixed Content" pada form submission
        
        // Kita bisa cek apakah aplikasi berjalan di environment produksi atau jika APP_URL sudah HTTPS
        // Hal ini penting agar di localhost (HTTP) tidak terjadi redirect loop.
        if (App::environment('production') || str_contains(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
        
        // Catatan: Jika Anda tidak yakin tentang environment atau APP_URL, 
        // Anda bisa menggunakan pengecekan sederhana ini:
        /*
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        */
    }
}
