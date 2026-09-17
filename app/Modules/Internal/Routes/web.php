<?php

use App\Modules\Internal\Http\Controllers\CommentController;
use App\Modules\Internal\Http\Controllers\IdeaDashboardController;
use App\Modules\Internal\Http\Controllers\IdeaDetailController;
use App\Modules\Internal\Http\Controllers\IdeaMergeController;
use App\Modules\Internal\Http\Controllers\IdeaStatusController;
use App\Modules\Internal\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::prefix('internal')->middleware(['auth', 'team'])->name('internal.')->group(function () {
        Route::get('/', IdeaDashboardController::class)->name('ideas.index');
        Route::get('/ideas/{idea}', [IdeaDetailController::class, 'show'])->name('ideas.show');
        Route::post('/ideas/{idea}/comments', [CommentController::class, 'store'])->name('ideas.comments.store');
        Route::post('/ideas/{idea}/notes', [NoteController::class, 'store'])->name('ideas.notes.store');
        Route::patch('/ideas/{idea}/status', [IdeaStatusController::class, 'update'])->name('ideas.status.update');
        Route::post('/ideas/{idea}/merge', [IdeaMergeController::class, 'store'])->name('ideas.merge.store');
    });
});
