<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AccountSettingsController extends Controller
{
    public function edit()
    {
        return Inertia::render('Account/Settings');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'indisposable',
                Rule::unique('users')->ignore($request->user()->id),
            ],
        ]);

        $request->user()->update($validated);

        return redirect('/account/settings');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.current_password' => 'The provided password does not match your current password.',
        ]);

        $request->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect('/account/settings');
    }
}
