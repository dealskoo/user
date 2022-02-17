# User Center of [Dealskoo](https://www.dealskoo.com)

## Remove file

- database/migrations/2014_10_12_000000_create_users_table.php
- database/migrations/2014_10_12_100000_create_password_resets_table.php
- database/factories/UserFactory.php

## Install

```base
$ composer require dealskoo\user
```

### Publish vendor

```base 
$ php artisan vendor:publish --provider="Dealskoo\User\Providers\UserServiceProvider" --tag=public
```

### Publish config

```base 
$ php artisan vendor:publish --provider="Dealskoo\User\Providers\UserServiceProvider" --tag=config
```

### Publish lang

```base 
$ php artisan vendor:publish --provider="Dealskoo\User\Providers\UserServiceProvider" --tag=lang
```

## Register Guards

Edit `config\auth.php`

```php
return [
    'defaults' => [
        'guard' => 'user',
        'passwords' => 'users',
    ],
    'guards' => [
        'user' => [
            'driver' => 'session',
            'provider' => 'users'
        ]
    ],
    'providers' => [
        'driver' => 'eloquent',
        'users' => Dealskoo\User\Models\User::class,
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'user_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ]
    ],
];
```

```php
namespace App\Http\Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if ($request->is(config('admin.route.prefix') . '/*')) {
                return route('admin.login');
            }  else {
                return route('user.login',[config('country.prefix')=>request()->country()->alpha2]);
            }
        }
    }
```

```php
namespace App\Http\Middleware;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param string|null ...$guards
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard == 'admin') {
                    return redirect(route('admin.dashboard'));
                } else {
                    return redirect(route('user.dashboard',[config('country.prefix')=>request()->country()->alpha2]));
                }
            }
        }

        return $next($request);
    }
}
```

## Add Listen

```php
<?php

namespace App\Providers;

use Dealskoo\User\Events\UserRegistered;
use Dealskoo\User\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserRegistered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

```

## Add Middleware

`App\Http\Kernel.php`

```php
    protected $routeMiddleware = [
        'active' => \Dealskoo\User\Http\Middleware\ActiveAuth::class,
    ];
```

## Support

- [Dealskoo](https://www.dealskoo.com)
- [Best Deals](https://www.dealskoo.com/best_deals)
- [Promo Codes](https://www.dealskoo.com/promo_codes)
