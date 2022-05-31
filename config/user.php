<?php
return [
    'route' => [
        'prefix' => env('USER_ROUTE_PREFIX', 'user'),
    ],
    'title' => 'User Center',
    'logo' => '/vendor/user/images/logo.svg',
    'logo_dark' => '/vendor/user/images/logo_dark.svg',
    'logo_sm' => '/vendor/user/images/logo_sm.svg',
    'logo_sm_dark' => '/vendor/user/images/logo_sm_dark.svg',
    'profile_prefix' => 'http://127.0.0.1/u/',
    'copyright' => '2014 - ' . date('Y') . ' ' . config('app.name'),
    'footer_menus' => [[
        'name' => 'About',
        'url' => 'user.dashboard'
    ], [
        'name' => 'Support',
        'url' => 'user.register'
    ], [
        'name' => 'Contact US',
        'url' => 'user.login'
    ]],
    'terms_and_conditions_url' => 'user.login',
];
