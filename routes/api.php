<?php

use Illuminate\Support\Facades\Route;

$versionPrefix = '/' . config('twill.api.version');

if (config('twill.api.endpoints.index')) {
    Route::get($versionPrefix, 'IndexController@index');
}

if (config('twill.enabled.block-editor') && config('twill.api.endpoints.blocks')) {
    Route::get($versionPrefix . '/blocks', 'BlockController@index');
    Route::get($versionPrefix . '/blocks/{block}', 'BlockController@show');
}

if (config('twill.enabled.media-library') && config('twill.api.endpoints.medias')) {
    Route::get($versionPrefix . '/medias', 'MediaController@index');
    Route::get($versionPrefix . '/medias/{media}', 'MediaController@show');
}

if (config('twill.enabled.file-library') && config('twill.api.endpoints.files')) {
    Route::get($versionPrefix . '/files', 'FileController@index');
    Route::get($versionPrefix . '/files/{file}', 'FileController@show');
}

if (config('twill.enabled.buckets') && config('twill.api.endpoints.features')) {
    Route::get($versionPrefix . '/features', 'FeatureController@index');
    Route::get($versionPrefix . '/features/{feature}', 'FeatureController@show');
}

if (config('twill.api.endpoints.tags')) {
    Route::get($versionPrefix . '/tags', 'TagController@index');
    Route::get($versionPrefix . '/tags/{tag}', 'TagController@show');
}

if (config('twill.enabled.users-management') && config('twill.api.endpoints.users')) {
    Route::get($versionPrefix . '/users', 'UserController@index');
    Route::get($versionPrefix . '/users/{user}', 'UserController@show');
}

if (config('twill.enabled.settings') && config('twill.api.endpoints.settings')) {
    Route::get($versionPrefix . '/settings', 'SettingController@index');
}
