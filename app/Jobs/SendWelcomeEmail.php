<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class SendWelcomeEmail implements ShouldQueue
{
    use Queueable;

    public function __construct(public User $user) {}

    public function handle(): void
    {
        if ($this->user->welcome_email_sent_at !== null) {
            return;
        }

        Http::withToken(config('services.mailer.token'))
            ->post(config('services.mailer.endpoint'), [
                'to' => $this->user->email,
                'subject' => 'Welcome to FeedbackPit',
                'text' => "Hi {$this->user->first_name}, welcome to FeedbackPit! We're glad you're here.",
            ]);

        $this->user->forceFill(['welcome_email_sent_at' => now()])->save();
    }
}
