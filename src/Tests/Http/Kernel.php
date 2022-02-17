<?php

namespace Dealskoo\User\Tests\Http;

use Dealskoo\Admin\Http\Middleware\AdminLocalization;
use Dealskoo\Country\Http\Middleware\Localization;
use Dealskoo\User\Tests\Http\Middleware\Authenticate;
use Dealskoo\User\Tests\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Orchestra\Testbench\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'password.confirm' => RequirePassword::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EnsureEmailIsVerified::class,
        'admin_locale' => AdminLocalization::class,
        'locale' => Localization::class,
        'admin_active' => \Dealskoo\Admin\Http\Middleware\ActiveAuth::class,
        'active' => \Dealskoo\User\Http\Middleware\ActiveAuth::class,
    ];
}
