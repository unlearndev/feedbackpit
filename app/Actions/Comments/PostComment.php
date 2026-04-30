<?php

namespace App\Actions\Comments;

use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use App\Notifications\IdeaCommentPosted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class PostComment
{
    public function __invoke(User $author, Idea $idea, string $body): Comment
    {
        return DB::transaction(function () use ($author, $idea, $body) {
            $comment = new Comment([
                'body' => $body,
                'is_internal' => false,
            ]);
            $comment->user()->associate($author);
            $comment->idea()->associate($idea);
            $comment->save();

            $idea->subscribers()->syncWithoutDetaching([$author->id]);

            if ($author->is_team_member) {
                $recipients = $idea->subscribers()
                    ->where('users.id', '!=', $author->id)
                    ->get();

                if ($recipients->isNotEmpty()) {
                    Notification::send($recipients, new IdeaCommentPosted($comment));
                }
            }

            return $comment;
        });
    }
}
