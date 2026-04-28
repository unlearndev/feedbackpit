<?php

namespace App\Observers;

use App\Models\Idea;

class IdeaObserver
{
    public function created(Idea $idea): void
    {
        $idea->subscribers()->syncWithoutDetaching([$idea->user_id]);
    }
}
