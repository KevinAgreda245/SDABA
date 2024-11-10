<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator as PaginationPaginator;
use Illuminate\Support\ServiceProvider;
//Configuración de rutina
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
//Para asignar un super administrador
use Illuminate\Support\Facades\Gate;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        //Definición de super administrador, al que le otorgan todos los permisos
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}
