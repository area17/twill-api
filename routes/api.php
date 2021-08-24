<?php

use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

JsonApiRoute::server('v1')
    ->prefix('v1')
    ->namespace('A17\Twill\API\JsonApi\V1')
    ->resources(function ($server) {
        if (config('twill.enabled.block-editor') && config('twill.api.endpoints.blocks')) {
            $server->resource('blocks', '\\' . JsonApiController::class);
        }

        if (config('twill.enabled.media-library') && config('twill.api.endpoints.medias')) {
            $server->resource('media', '\\' . JsonApiController::class);
        }

        if (config('twill.enabled.file-library') && config('twill.api.endpoints.files')) {
            $server->resource('files', '\\' . JsonApiController::class);
        }

        if (config('twill.enabled.buckets') && config('twill.api.endpoints.features')) {
            $server->resource('features', '\\' . JsonApiController::class);
        }

        if (config('twill.api.endpoints.tags')) {
            $server->resource('tags', '\\' . JsonApiController::class);
        }

        if (config('twill.enabled.users-management') && config('twill.api.endpoints.users')) {
            $server->resource('users', '\\' . JsonApiController::class);
        }

        if (config('twill.enabled.settings') && config('twill.api.endpoints.settings')) {
            $server->resource('settings', '\\' . JsonApiController::class);
        }
    });
