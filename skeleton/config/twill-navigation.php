<?php

return [

    'books' => [
        'title' => 'Books',
        'module' => true
    ],

    'authors' => [
        'title' => 'Authors',
        'module' => true
    ],

    'settings' => [
        'title' => 'Settings',
        'route' => 'admin.settings',
        'params' => ['section' => 'general'],
        'primary_navigation' => [
            'general' => [
                'title' => 'General',
                'route' => 'admin.settings',
                'params' => ['section' => 'general']
            ],
        ]
    ],

];
