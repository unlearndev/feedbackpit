<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class AccountSettingsController extends Controller
{
    public function edit()
    {
        return Inertia::render('Account/Settings');
    }

    public function update(Request $request, UpdatesUserProfileInformation $updater)
    {
        $updater->update($request->user(), array_merge($request->all(), ['name' => $request->user()->name]));

        return redirect('/account/settings')->with('message', 'Your changes have been saved.');
    }

    public function updatePassword(Request $request, UpdatesUserPasswords $updater)
    {
        $updater->update($request->user(), $request->all());

        return redirect('/account/settings')->with('message', 'Your password has been updated.');
    }
}
