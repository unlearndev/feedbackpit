<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('account.settings.edit')->with('status', 'Your changes have been saved.');
    }

    public function updatePassword(Request $request, UpdatesUserPasswords $updater)
    {
        $updater->update($request->user(), $request->only(['current_password', 'password', 'password_confirmation']));

        return redirect()->route('account.settings.edit')->with('status', 'Your password has been updated.');
    }
}
