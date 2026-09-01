<?php

namespace App\Actions\Votes;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ToggleVote
{
    public function __invoke(User $user, Idea $idea): void
    {
        DB::transaction(function () use ($user, $idea) {
            $idea->lockForUpdate();

            $hasVoted = $idea->voters()->where('user_id', $user->id)->exists();

            if ($hasVoted) {
                $idea->voters()->detach($user->id);
                $idea->decrement('votes');
            } else {
                $idea->voters()->attach($user->id);
                $idea->increment('votes');
                $idea->subscribers()->syncWithoutDetaching([$user->id]);
            }
        });
    }
}
