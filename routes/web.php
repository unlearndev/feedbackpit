<?php

use App\Http\Controllers\AccountSettingsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::middleware('auth')->group(function () {
    Route::get('/account/settings', [AccountSettingsController::class, 'edit']);
    Route::put('/account/settings', [AccountSettingsController::class, 'update']);
    Route::put('/account/password', [AccountSettingsController::class, 'updatePassword']);
});
