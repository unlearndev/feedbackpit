<?php

namespace App\Notifications;

use App\Models\IdeaStatusUpdate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class IdeaStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public IdeaStatusUpdate $statusUpdate) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $idea = $this->statusUpdate->idea;

        return (new MailMessage)
            ->subject('Status update on "'.$idea->title.'"')
            ->markdown('mail.ideas.status-changed', [
                'idea' => $idea,
                'oldStatus' => $this->statusUpdate->from_status,
                'newStatus' => $this->statusUpdate->to_status,
                'message' => $this->statusUpdate->message,
                'ideaUrl' => route('feedback.show', $idea),
                'unsubscribeUrl' => URL::signedRoute('feedback.unsubscribe', [
                    'idea' => $idea->id,
                    'user' => $notifiable->id,
                ]),
            ]);
    }
}
