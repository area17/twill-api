<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Placeholder Background Color
    |--------------------------------------------------------------------------
    |
    | The color which should be used to fill the image space on a page.
    | Examples: 'gray', 'transparent', 'rgba(0, 0, 0, 0.25)'
    |
    */
    'background_color' => '#e3e3e3',

    /*
    |--------------------------------------------------------------------------
    | Enable Low Quality Placeholder
    |--------------------------------------------------------------------------
    |
    | Tells if LQIP should be used if it is available.
    |
    */
    'lqip' => false,

    /*
    |--------------------------------------------------------------------------
    | Enable WebP Support
    |--------------------------------------------------------------------------
    |
    | Add sources support for WepP images.
    |
    */
    'webp_support' => true,

    /*
    |--------------------------------------------------------------------------
    | Image Presets
    |--------------------------------------------------------------------------
    |
    | Define image presets here.
    |
    */
    'presets' => [
        'cover' => [
            'crop' => 'default',
            'sizes' => '75vw',
            'sources' => [
                [
                    'crop' => 'mobile',
                    'media_query' => '(max-width: 767px)',
                ],
                [
                    'crop' => 'default',
                    'media_query' => '(min-width: 767px) and (max-width: 1023px)',
                ],
            ],
        ],
    ],

];
