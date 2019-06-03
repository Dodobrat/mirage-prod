<?php


return [
    /*
     * Package version
     */
    'package_version' => '1.0.0',
    /*
     * URL Prefix
     */
    'url_prefix' => 'admin',

    /*
    * Views Prefix
    */
    'views_prefix' => 'administration',
    'admin_prefix' => 'administration',


    /*
     * Administrator guard name
     */
    'guard' => 'administrator',

    'file_prefix' => 'charlotte/administration/',

    /*
     * Supported Languages
     */
    'admin_supported_locales' => [
        'en',
        'bg',
        'fr'
    ],

    /*
   * Settings Images Conversions
   */
    'settings_images' => [
        'thumb' => [
            'width' => 1920,
            'height' => 1080,
        ],
    ],

    //Default fields for settings
    'settings_default_fields' => [
        'global_email' => [
            'title' => 'contacts::admin.global_email',  //this will be converted to trans
            'type' => 'text'
        ],
        'global_phone' => [
            'title' => 'contacts::admin.global_phone',  //this will be converted to trans
            'type' => 'text'
        ],
        'fb_link' => [
            'title' => 'contacts::admin.fb',  //this will be converted to trans
            'type' => 'text'
        ],
        'ig_link' => [
            'title' => 'contacts::admin.ig',  //this will be converted to trans
            'type' => 'text'
        ],
        'pi_link' => [
            'title' => 'contacts::admin.pi',  //this will be converted to trans
            'type' => 'text'
        ],
        'li_link' => [
            'title' => 'contacts::admin.li',  //this will be converted to trans
            'type' => 'text'
        ]
    ]

];
