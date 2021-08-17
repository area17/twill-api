<?php

namespace A17\Twill\API;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $controllerNamespace = 'App\\Http\\Controllers\\API';

    /**
     * Bootstraps the package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMacros();

        parent::boot();
    }

    protected function registerMacros()
    {
        $controllerNamespace = $this->controllerNamespace;

        Route::macro('apiModule', function ($moduleName) use ($controllerNamespace) {
            $versionPrefix = config('twill.api.version');
            $modelName = Str::ucfirst(Str::singular($moduleName));
            $route = $versionPrefix . '/'. $moduleName;
            $controller = $controllerNamespace.'\\'.$modelName.'Controller@list';

            Route::get($route, $controller);
        });
    }
}
