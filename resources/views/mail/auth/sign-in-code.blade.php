<x-mail::message>
# Your sign-in code

Use the code below to finish signing in to FeedbackPit. The code will expire in {{ $expiresInMinutes }} minutes.

<x-mail::panel>
# {{ $code }}
</x-mail::panel>

If you didn't request this code, you can safely ignore this email.
</x-mail::message>
