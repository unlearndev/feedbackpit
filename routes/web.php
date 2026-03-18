<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\VoteController;
use App\Models\Idea;
use Illuminate\Support\Facades\Route;

Route::get('/', function (\Illuminate\Http\Request $request) {
    $user = $request->user();

    $ideas = Idea::with('user:id,name')
        ->when($user, fn ($q) => $q->with(['voters' => fn ($q) => $q->where('user_id', $user->id)->select('users.id')]))
        ->latest()
        ->get()
        ->each(function ($idea) use ($user) {
            $idea->has_voted = $user ? $idea->voters->isNotEmpty() : false;
            $idea->unsetRelation('voters');
        });

    return inertia('Home', ['ideas' => $ideas]);
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/account/settings', [AccountSettingsController::class, 'edit'])->name('account.settings.edit');
    Route::put('/account/settings', [AccountSettingsController::class, 'update'])->name('account.settings.update');
    Route::put('/account/password', [AccountSettingsController::class, 'updatePassword'])->name('account.password.update');

    Route::get('/ideas/create', [IdeaController::class, 'create'])->name('ideas.create');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');

    Route::post('/ideas/{idea}/vote', VoteController::class)->name('ideas.vote');
});

Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('ideas.show');
