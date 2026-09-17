<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountNotificationsController;
use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('landing');
Route::get('/about', AboutController::class)->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/account/settings', [AccountSettingsController::class, 'edit'])->name('account.settings.edit');
    Route::put('/account/settings', [AccountSettingsController::class, 'update'])->name('account.settings.update');
    Route::put('/account/password', [AccountSettingsController::class, 'updatePassword'])->name('account.password.update');

    Route::get('/account/notifications', [AccountNotificationsController::class, 'edit'])->name('account.notifications.edit');
    Route::post('/account/notifications/{idea}', [AccountNotificationsController::class, 'store'])->name('account.notifications.store');
    Route::delete('/account/notifications/{idea}', [AccountNotificationsController::class, 'destroy'])->name('account.notifications.destroy');
});
