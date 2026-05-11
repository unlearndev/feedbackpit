<?php

namespace App\Http\Controllers;

use App\Actions\Auth\IssueSignInCode;
use App\Http\Requests\ConfirmSignInCodeRequest;
use App\Http\Requests\SendSignInCodeRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Response;

class SignInCodeController extends Controller
{
    public function create(): Response
    {
        return inertia('Auth/SignInCode/Request');
    }

    public function store(SendSignInCodeRequest $request, IssueSignInCode $issueSignInCode): RedirectResponse
    {
        $email = (string) $request->input('email');

        $user = User::where('email', $email)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => 'No account found for that email address.',
            ]);
        }

        $issueSignInCode($user);

        return redirect()
            ->route('login.code.confirm', ['email' => $email])
            ->with('status', 'Code sent — check your inbox.');
    }

    public function confirmForm(): Response
    {
        return inertia('Auth/SignInCode/Confirm', [
            'email' => (string) request()->query('email', ''),
        ]);
    }

    public function confirm(ConfirmSignInCodeRequest $request): RedirectResponse
    {
        $email = (string) $request->input('email');
        $code = (string) $request->input('code');

        $user = User::where('email', $email)->first();

        $signInCode = $user
            ?->signInCodes()
            ->latest()
            ->first();

        if (! $user || ! $signInCode || $signInCode->code !== $code) {
            throw ValidationException::withMessages([
                'code' => 'That code is not valid.',
            ]);
        }

        if (now() >= $signInCode->expires_at) {
            throw ValidationException::withMessages([
                'code' => 'That code has expired.',
            ]);
        }

        $signInCode->delete();

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}
