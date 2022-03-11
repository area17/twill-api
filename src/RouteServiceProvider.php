<?php

namespace A17\Twill\API;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'A17\Twill\API\JsonApi\V1';

    public function register()
    {
        $this->registerMacros();

        parent::boot();
    }

    protected function registerMacros()
    {
        $controllerNamespace = 'App\\Http\\Controllers\\Api';

        Route::macro('moduleResource', function ($moduleName) use ($controllerNamespace) {
            $versionPrefix = config('twill-api.version');
            $modelName = Str::ucfirst(Str::singular($moduleName));
            $route = $versionPrefix . '/'. $moduleName;
            $controller = $controllerNamespace.'\\'.$modelName.'Controller';

            Route::get($route, [$controller, 'index']);
            Route::get($route . '/{id}', [$controller, 'show']);
        });
    }
}
