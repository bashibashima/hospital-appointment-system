<?php
namespace App\Providers;


use Laravel\Fortify\Contracts\LoginResponse;
use App\Http\Responses\LoginResponse as CustomLoginResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;


use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\IsDoctor;
use App\Http\Middleware\IsPatient;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);


        Route::aliasMiddleware('is_admin', IsAdmin::class);
        Route::aliasMiddleware('is_doctor', IsDoctor::class);
        Route::aliasMiddleware('is_patient', IsPatient::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         Route::aliasMiddleware('is_admin', IsAdmin::class);
         Route::aliasMiddleware('is_doctor', IsDoctor::class);
         Route::aliasMiddleware('is_patient', IsPatient::class);
           
    }
}
