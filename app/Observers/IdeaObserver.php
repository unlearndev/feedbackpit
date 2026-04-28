<?php

namespace App\Observers;

use App\Enums\IdeaStatus;
use App\Models\Idea;
use App\Notifications\IdeaStatusChanged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class IdeaObserver
{
    public function created(Idea $idea): void
    {
        $idea->subscribers()->syncWithoutDetaching([$idea->user_id]);
    }

    public function updated(Idea $idea): void
    {
        if (! $idea->wasChanged('status')) {
            return;
        }

        $oldStatus = IdeaStatus::from($idea->getRawOriginal('status'));
        $actorId = Auth::id();

        $recipients = $idea->subscribers()
            ->when($actorId, fn ($query) => $query->where('users.id', '!=', $actorId))
            ->get();

        if ($recipients->isEmpty()) {
            return;
        }

        Notification::send($recipients, new IdeaStatusChanged($idea, $oldStatus));
    }
}
