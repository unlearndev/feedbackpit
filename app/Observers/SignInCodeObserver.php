<?php

namespace App\Observers;

use App\Mail\SignInCodeMail;
use App\Models\SignInCode;
use Illuminate\Support\Facades\Mail;

class SignInCodeObserver
{
    public function created(SignInCode $signInCode): void
    {
        try {
            Mail::to($signInCode->user->email)->send(new SignInCodeMail($signInCode));
        } catch (\Throwable $e) {
            //
        }
    }
}
