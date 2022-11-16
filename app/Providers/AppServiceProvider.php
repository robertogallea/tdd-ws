<?php

namespace App\Providers;

use App\Services\ConversionServiceInterface;
use App\Services\EloquentConversionService;
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
//        $this->app->bind(
//            ConversionServiceInterface::class,
//            EloquentConversionService::class,
//        );
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
