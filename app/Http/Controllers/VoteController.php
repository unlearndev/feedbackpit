<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function __invoke(Idea $idea): RedirectResponse
    {
        $user = request()->user();

        DB::transaction(function () use ($idea, $user) {
            $idea->lockForUpdate();

            $exists = $idea->voters()->where('user_id', $user->id)->exists();

            if ($exists) {
                $idea->voters()->detach($user->id);
                $idea->decrement('votes');
            } else {
                $idea->voters()->attach($user->id);
                $idea->increment('votes');
                $idea->subscribers()->syncWithoutDetaching([$user->id]);
            }
        });

        return redirect()->back();
    }
}
