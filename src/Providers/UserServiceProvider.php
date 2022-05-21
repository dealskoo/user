<?php

namespace Dealskoo\User\Providers;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Admin\Permission;
use Dealskoo\User\Contracts\Dashboard;
use Dealskoo\User\Contracts\Searcher;
use Dealskoo\User\Contracts\Support\DefaultDashboard;
use Dealskoo\User\Contracts\Support\DefaultSearcher;
use Dealskoo\User\Facades\UserMenu;
use Dealskoo\User\Menu\UserPresenter;
use Illuminate\Support\ServiceProvider;
use Nwidart\Menus\Facades\Menu;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/user.php', 'user');
        $this->app->bind(Dashboard::class, DefaultDashboard::class);
        $this->app->bind(Searcher::class, DefaultSearcher::class);
        $this->app->singleton('user_menu', function () {
            Menu::create('user_navbar', function ($menu) {
                $menu->enableOrdering();
                $menu->setPresenter(UserPresenter::class);
            });

            return Menu::instance('user_navbar');
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->publishes([
                __DIR__ . '/../../config/user.php' => config_path('user.php')
            ], 'config');

            $this->publishes([
                __DIR__ . '/../../public' => public_path('vendor/user')
            ], 'public');

            $this->publishes([
                __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/user'),
            ], 'lang');
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'user');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'user');

        AdminMenu::route('admin.users.index', 'user::user.users', [], ['icon' => 'uil-users-alt', 'permission' => 'users.index'])->order(5);
        PermissionManager::add(new Permission('users.index', 'Users List'));
        PermissionManager::add(new Permission('users.show', 'View User'), 'users.index');
        PermissionManager::add(new Permission('users.edit', 'Edit User'), 'users.index');
        PermissionManager::add(new Permission('users.login', 'Login User'), 'users.login');

        UserMenu::route('user.dashboard', 'user::user.dashboard', [], ['icon' => 'uil-dashboard me-1']);
    }
}
