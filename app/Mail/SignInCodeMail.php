<?php

namespace App\Mail;

use App\Models\SignInCode;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SignInCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public SignInCode $signInCode) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your FeedbackPit sign-in code',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.auth.sign-in-code',
            with: [
                'code' => $this->signInCode->code,
                'expiresInMinutes' => (int) now()->diffInMinutes($this->signInCode->expires_at, false),
            ],
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
