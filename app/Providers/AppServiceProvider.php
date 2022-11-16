<?php

namespace App\Providers;

use App\Services\APIConversionService;
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
