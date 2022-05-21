<?php

use Dealskoo\User\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'admin_locale'])->prefix(config('admin.route.prefix'))->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function () {

    });

    Route::middleware(['auth:admin', 'admin_active'])->group(function () {
        Route::get('users/{id}/login',[UserController::class,'login'])->name('users.login');
        Route::resource('users', UserController::class)->except(['create', 'store', 'destroy']);
    });

});
