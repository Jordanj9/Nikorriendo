<?php

namespace App\Providers;

use App\Observers\ServicioObserver;
use App\Servicio;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Servicio::observe(ServicioObserver::class);
    }
}
