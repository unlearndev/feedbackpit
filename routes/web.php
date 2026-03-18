<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/account/settings', [AccountSettingsController::class, 'edit'])->name('account.settings.edit');
    Route::put('/account/settings', [AccountSettingsController::class, 'update'])->name('account.settings.update');
    Route::put('/account/password', [AccountSettingsController::class, 'updatePassword'])->name('account.password.update');

    Route::get('/ideas/create', [IdeaController::class, 'create'])->name('ideas.create');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');

    Route::post('/ideas/{idea}/vote', VoteController::class)->name('ideas.vote');
});

Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('ideas.show');
