<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;


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


public function boot()
{
    // إجبار لارافيل على توليد روابط HTTPS عند استخدام ngrok
    if (str_contains(request()->gethttphost(), 'ngrok-free.dev')) {
        URL::forceScheme('https');
    }
}
}