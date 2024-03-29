<?php

use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

$version = config('twill-api.version');
$prefix = implode('/', [
    config('twill-api.prefix'),
    $version,
]);

if (config("jsonapi.servers.$version")) {
    JsonApiRoute::server($version)
        ->prefix($prefix)
        ->namespace(config('twill-api.namespace'))
        ->middleware(...config('twill-api.middleware'))
        ->withoutMiddleware(\Illuminate\Routing\Middleware\SubstituteBindings::class)
        ->resources(function ($server) {
            if (!empty(config('twill-api.related_types'))) {
                $server->resource('related-items', '\\' . JsonApiController::class)->relationships(function ($relationships) {
                    $relationships->hasMany('related');
                })->readOnly();
            }

            if (config('twill.enabled.block-editor') && config('twill-api.endpoints.blocks')) {
                $server->resource('blocks', '\\' . JsonApiController::class)->relationships(function ($relationships) {
                    $relationships->hasMany('related-items');
                    $relationships->hasMany('media');
                    $relationships->hasMany('files');
                    $relationships->hasMany('blocks');
                })->readOnly();
            }

            if (config('twill.enabled.media-library') && config('twill-api.endpoints.media')) {
                $server->resource('media', '\\' . JsonApiController::class)->readOnly();
            }

            if (config('twill.enabled.file-library') && config('twill-api.endpoints.files')) {
                $server->resource('files', '\\' . JsonApiController::class)->readOnly();
            }

            if (config('twill.enabled.buckets') && config('twill-api.endpoints.features') && !empty(config('twill-api.featured_types'))) {
                $server->resource('features', '\\' . JsonApiController::class)->relationships(function ($relationships) {
                    $relationships->hasMany('featured');
                })->readOnly();
            }

            if (config('twill-api.endpoints.tags')) {
                $server->resource('tags', '\\' . JsonApiController::class)->readOnly();
            }

            if (config('twill.enabled.users-management') && config('twill-api.endpoints.users')) {
                $server->resource('users', '\\' . JsonApiController::class)->readOnly();
            }

            if (config('twill.enabled.settings') && config('twill-api.endpoints.settings')) {
                $server->resource('settings', '\\' . JsonApiController::class)->relationships(function ($relationships) {
                    $relationships->hasMany('media');
                })->readOnly();
            }
        });
}
