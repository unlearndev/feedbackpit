<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class IdeaCommentPosted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Comment $comment) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $idea = $this->comment->idea;

        return (new MailMessage)
            ->subject('New comment on "'.$idea->title.'"')
            ->markdown('mail.ideas.comment-posted', [
                'idea' => $idea,
                'commenterName' => $this->comment->user->name,
                'excerpt' => Str::limit($this->comment->body, 280),
                'ideaUrl' => route('feedback.show', $idea),
                'unsubscribeUrl' => URL::signedRoute('feedback.unsubscribe', [
                    'idea' => $idea->id,
                    'user' => $notifiable->id,
                ]),
            ]);
    }
}
