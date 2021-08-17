<?php

namespace A17\Twill\API;

use A17\Twill\API\RouteServiceProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    protected $providers = [
        RouteServiceProvider::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerProviders();

        $this->app->singleton('twill.api', function ($app) {
            return $app->make('A17\Twill\API\Controller');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/api.php', 'twill.api');

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    /**
     * Registers the package service providers.
     *
     * @return void
     */
    private function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
}
