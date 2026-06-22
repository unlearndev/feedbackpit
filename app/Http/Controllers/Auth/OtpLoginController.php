<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\Random;

class OtpLoginController extends Controller
{
    public function create()
    {
        return inertia('Auth/OtpRequest');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors([
                'email' => 'We could not find an account with that email address.',
            ]);
        }

        $code = Random::generate(config('otp.length'), '0-9');

        $user->loginCodes()->create([
            'code' => $code,
            'expires_at' => now()->addMinutes(config('otp.expiry')),
        ]);

        Mail::to($user->email)->send(new LoginCodeMail($code));

        return redirect()->route('otp.verify')->with('email', $request->email);
    }

    public function verify()
    {
        return inertia('Auth/OtpVerify', [
            'email' => session('email'),
        ]);
    }

    public function attempt(Request $request)
    {
        $request->validate([
            'code' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors([
                'code' => 'That code is invalid or has expired.',
            ]);
        }

        $loginCode = $user->loginCodes()
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (! $loginCode) {
            return back()->withErrors([
                'code' => 'That code is invalid or has expired.',
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
