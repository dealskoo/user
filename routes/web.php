<?php

use Dealskoo\User\Http\Controllers\AccountController;
use Dealskoo\User\Http\Controllers\Auth\AuthenticatedSessionController;
use Dealskoo\User\Http\Controllers\Auth\ConfirmablePasswordController;
use Dealskoo\User\Http\Controllers\Auth\EmailVerificationNotificationController;
use Dealskoo\User\Http\Controllers\Auth\EmailVerificationPromptController;
use Dealskoo\User\Http\Controllers\Auth\NewPasswordController;
use Dealskoo\User\Http\Controllers\Auth\PasswordResetLinkController;
use Dealskoo\User\Http\Controllers\Auth\RegisteredUserController;
use Dealskoo\User\Http\Controllers\Auth\VerifyEmailController;
use Dealskoo\User\Http\Controllers\DashboardController;
use Dealskoo\User\Http\Controllers\NotificationController;
use Dealskoo\User\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/verify', function () {
    return redirect(route('user.verification.notice', [config('country.prefix') => Str::upper(config('country.default_alpha2'))]), 301);
})->name('verification.notice');

Route::get('/confirm', function () {
    return redirect(route('user.verification.notice', [config('country.prefix') => Str::upper(config('country.default_alpha2'))]), 301);
})->name('password.confirm');

Route::middleware(['web', 'locale'])->prefix('/{' . config('country.prefix') . '}')->name('user.')->group(function () {

    Route::view('/banned', 'user::auth.banned')->name('banned');

    Route::middleware(['guest'])->group(function () {
        Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
        Route::post('/register', [RegisteredUserController::class, 'store']);
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store']);
        Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');

        Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware(['throttle:6,1'])
            ->name('verification.send');

        Route::middleware(['verified:verification.notice', 'active'])->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'handle'])->name('dashboard');
            Route::prefix(config('user.route.prefix'))->get('/search', [SearchController::class, 'handle'])->name('search');

            Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
            Route::middleware(['throttle:6,1'])->post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

            Route::prefix('/account')->name('account.')->group(function () {
                Route::view('/', 'user::account.profile')->name('profile');

                Route::post('/', [AccountController::class, 'store'])->name('profile');

                Route::post('/avatar', [AccountController::class, 'avatar'])->name('avatar');

                Route::view('/email', 'user::account.email')->name('email');

                Route::middleware(['throttle:6,1'])->post('/email', [AccountController::class, 'email'])->name('email');

                Route::middleware(['signed', 'throttle:6,1'])->get('/email/verify/{hash}', [AccountController::class, 'emailVerify'])->name('email.verify');

                Route::view('/password', 'user::account.password')->name('password');

                Route::post('/password', [AccountController::class, 'password'])->name('password');
            });

            Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

            Route::name('notification.')->group(function () {
                Route::get('/notifications', [NotificationController::class, 'list'])->name('list');
                Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('unread');
                Route::get('/notifications/all_read', [NotificationController::class, 'allRead'])->name('all_read');
                Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('show');
            });

            Route::middleware(['password.confirm:password.confirm'])->group(function () {

            });
        });
    });
});
