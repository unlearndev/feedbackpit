<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('landing');
Route::get('/about', AboutController::class)->name('about');
Route::get('/dashboard', DashboardController::class)->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/account/settings', [AccountSettingsController::class, 'edit'])->name('account.settings.edit');
    Route::put('/account/settings', [AccountSettingsController::class, 'update'])->name('account.settings.update');
    Route::put('/account/password', [AccountSettingsController::class, 'updatePassword'])->name('account.password.update');

    Route::get('/feedback/create', [IdeaController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [IdeaController::class, 'store'])->name('feedback.store');

    Route::post('/feedback/{idea}/vote', VoteController::class)->name('feedback.vote');
    Route::post('/feedback/{idea}/comments', [CommentController::class, 'store'])->name('feedback.comments.store');
});

Route::get('/feedback/{idea}', [IdeaController::class, 'show'])->name('feedback.show');
