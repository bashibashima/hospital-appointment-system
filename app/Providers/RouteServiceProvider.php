<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
   //public const HOME = '/redirect'; // 🔁 Redirect path after login
   public const HOME ='/patient/dashboard';
    /**
     * Register any application services.
     */
    public function boot(): void
    {
        // Leave empty for now
    }
}