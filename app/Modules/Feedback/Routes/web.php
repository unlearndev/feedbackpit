<?php

use App\Modules\Feedback\Http\Controllers\CommentController;
use App\Modules\Feedback\Http\Controllers\DashboardController;
use App\Modules\Feedback\Http\Controllers\IdeaController;
use App\Modules\Feedback\Http\Controllers\ReactionController;
use App\Modules\Feedback\Http\Controllers\UnsubscribeController;
use App\Modules\Feedback\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/feedback/create', [IdeaController::class, 'create'])->name('feedback.create');
        Route::post('/feedback', [IdeaController::class, 'store'])->name('feedback.store');

        Route::get('/feedback/{idea}/edit', [IdeaController::class, 'edit'])->name('feedback.edit');
        Route::put('/feedback/{idea}', [IdeaController::class, 'update'])->name('feedback.update');
        Route::delete('/feedback/{idea}', [IdeaController::class, 'destroy'])->name('feedback.destroy');

        Route::post('/feedback/{idea}/vote', VoteController::class)->name('feedback.vote');
        Route::post('/feedback/{idea}/reactions', ReactionController::class)->name('feedback.react');
        Route::post('/feedback/{idea}/comments', [CommentController::class, 'store'])->name('feedback.comments.store');
    });

    Route::get('/feedback/{idea}', [IdeaController::class, 'show'])->name('feedback.show');

    Route::get('/feedback/{idea}/unsubscribe/{user}', UnsubscribeController::class)
        ->middleware('signed')
        ->name('feedback.unsubscribe');
});
