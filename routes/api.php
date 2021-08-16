<?php

$versionPrefix = '/' . config('twill.api.version');

Route::prefix('api')->name('api')->group(function () use ($versionPrefix) {
    Route::get($versionPrefix, function () {
        return [];
    });
});
