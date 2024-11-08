<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//Configuración de rutina
//use Iluminate\Support\Facades\Schema;
//use Iluminate\Pagination\Paginator;

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
        //Parte de configuraciones de rutina.
        //Schema::defaultStringLength(191);
        //Paginator::useBooststrap();
    }
}
