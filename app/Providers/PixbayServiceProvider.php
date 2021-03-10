<?php

namespace App\Providers;

use App\Services\PixbayService\Client;
use App\Services\PixbayService\Config;
use Illuminate\Support\ServiceProvider;

class PixbayServiceProvider extends ServiceProvider
{
    const DOMAIN = '';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            return new Client($app->make(Config::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
