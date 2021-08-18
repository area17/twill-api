<?php

use Illuminate\Support\Facades\Route;

$versionPrefix = '/' . config('twill.api.version');

Route::get($versionPrefix, 'IndexController@index');

Route::get($versionPrefix . '/blocks', 'BlockController@list');
Route::get($versionPrefix . '/blocks/{block}', 'BlockController@show');

// Route::get($versionPrefix . '/medias', 'MediaController@list');
// Route::get($versionPrefix . '/medias/{media}', 'MediaController@show');

// Route::get($versionPrefix . '/files', 'FileController@list');
// Route::get($versionPrefix . '/files/{file}', 'FileController@show');

// Route::get($versionPrefix . '/features', 'FeatureController@list');
// Route::get($versionPrefix . '/features/{feature}', 'FeatureController@show');

// Route::get($versionPrefix . '/tags', 'TagController@list');
// Route::get($versionPrefix . '/tags/{tag}', 'TagController@show');

// Route::get($versionPrefix . '/users', 'UserController@list');
// Route::get($versionPrefix . '/users/{block}', 'UserController@show');

// Route::get($versionPrefix . '/settings', 'SettingController@list');
