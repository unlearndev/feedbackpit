<?php

namespace App\Observers;

use App\Models\Comment;
use App\Notifications\IdeaCommentPosted;
use Illuminate\Support\Facades\Notification;

class CommentObserver
{
    public function created(Comment $comment): void
    {
        if ($comment->is_internal) {
            return;
        }

        $comment->idea->subscribers()->syncWithoutDetaching([$comment->user_id]);

        if (! $comment->user->is_team_member) {
            return;
        }

        $recipients = $comment->idea->subscribers()
            ->where('users.id', '!=', $comment->user_id)
            ->get();

        if ($recipients->isEmpty()) {
            return;
        }

        Notification::send($recipients, new IdeaCommentPosted($comment));
    }
}
