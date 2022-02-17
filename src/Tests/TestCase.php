<?php

namespace Dealskoo\User\Tests;

use Dealskoo\User\Facades\UserMenu;
use Dealskoo\User\Models\User;
use Dealskoo\User\Providers\UserServiceProvider;
use Dealskoo\User\Tests\Http\Kernel;

abstract class TestCase extends \Dealskoo\Admin\Tests\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            UserServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'UserMenu' => UserMenu::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('auth.guards.user', [
            'driver' => 'session',
            'provider' => 'users',
        ]);
        $app['config']->set('auth.providers.users', [
            'driver' => 'eloquent',
            'model' => User::class,
        ]);
        $app['config']->set('auth.passwords.users', [
            'provider' => 'users',
            'table' => 'user_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ]);
    }

    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton(\Illuminate\Contracts\Http\Kernel::class, Kernel::class);
    }
}
