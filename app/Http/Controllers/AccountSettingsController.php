<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class AccountSettingsController extends Controller
{
    public function edit()
    {
        return inertia('Account/Settings');
    }

    public function update(Request $request, UpdatesUserProfileInformation $updater)
    {
        $updater->update($request->user(), [
            'name' => $request->user()->name,
            'email' => $request->input('email'),
        ]);

        return redirect()->route('account.settings.edit')->with('status', 'Your changes have been saved.');
    }

    public function updatePassword(Request $request, UpdatesUserPasswords $updater)
    {
        $updater->update($request->user(), $request->only(['current_password', 'password', 'password_confirmation']));

        return redirect()->route('account.settings.edit')->with('status', 'Your password has been updated.');
    }

    public function destroy(Request $request)
    {
        Validator::make($request->only('current_password'), [
            'current_password' => ['required', 'string', 'current_password:web'],
        ], [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ])->validate();

        $user = $request->user();

        Auth::guard('web')->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('status', 'Your account has been deleted.');
    }
}
