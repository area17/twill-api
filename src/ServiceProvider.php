<?php

namespace A17\Twill\API;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
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
}
