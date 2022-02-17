<?php

namespace Dealskoo\User\Providers;

use Dealskoo\User\Contracts\Dashboard;
use Dealskoo\User\Contracts\Searcher;
use Dealskoo\User\Contracts\Support\DefaultDashboard;
use Dealskoo\User\Contracts\Support\DefaultSearcher;
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

        Menu::create('user_navbar', function ($menu) {
            $menu->enableOrdering();
            $menu->setPresenter(UserPresenter::class);
            $menu->route('user.dashboard', 'user::user.dashboard', [config('country.prefix') => request()->country()->alpha2], ['icon' => 'uil-dashboard me-1']);
        });

    }
}
