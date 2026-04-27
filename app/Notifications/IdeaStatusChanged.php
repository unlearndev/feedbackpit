<?php

namespace App\Notifications;

use App\Enums\IdeaStatus;
use App\Models\Idea;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class IdeaStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Idea $idea, public IdeaStatus $oldStatus) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Status update on "'.$this->idea->title.'"')
            ->markdown('mail.ideas.status-changed', [
                'idea' => $this->idea,
                'oldStatus' => $this->oldStatus,
                'ideaUrl' => route('feedback.show', $this->idea),
                'unsubscribeUrl' => URL::signedRoute('feedback.unsubscribe', [
                    'idea' => $this->idea->id,
                    'user' => $notifiable->id,
                ]),
            ]);
    }
}
