<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendWelcomeEmail implements ShouldQueue
{
    use Queueable;

    public function __construct(public User $user) {}

    public function handle(): void
    {
        if ($this->user->welcome_email_sent_at !== null) {
            return;
        }

        $this->user->notify(new WelcomeNotification);

        $this->user->forceFill(['welcome_email_sent_at' => now()])->save();
    }
}
