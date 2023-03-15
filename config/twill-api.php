<?php

return [

    'prefix' => 'api',

    'version' => 'v1',

    'namespace' => '\App\Http\Controllers\TwillApi\V1',

    'middleware' => [
        'api'
    ],

    'endpoints' => [
        'index' => true,
        'blocks' => true,
        'media' => true,
        'files' => true,
        'features' => true,
        'tags' => true,
        'users' => true,
        'settings' => true,
    ],

    'related_types' => [
        // 'pages',
        // ...
    ],

    'featured_types' => [
        // 'pages',
        // ...
    ],

];
