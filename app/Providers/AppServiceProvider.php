<?php

namespace App\Providers;

use Cancionistica\Apis;
use Cancionistica\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public array $bindings = [
        Apis\ImageableApi::class => Services\ImageableService::class,
        Apis\PaymentApi::class => Services\PaymentService::class,
        Apis\OrderApi::class => Services\OrderService::class,
    ];


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        DB::listen(function ($query) {
//            logger($query->sql, $query->bindings);
//        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
