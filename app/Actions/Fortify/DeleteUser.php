<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DeleteUser
{
    /**
     * Validate and delete the given user.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function delete(User $user, array $input): void
    {
        Validator::make($input, [
            'password' => ['required', 'string', 'current_password:web'],
        ], [
            'password.current_password' => __('The provided password does not match your current password.'),
        ])->validate();

        // Persist a null remember_token so a subsequent guard logout() doesn't
        // re-save the deleted user via cycleRememberToken().
        $user->forceFill(['remember_token' => null])->save();
        $user->delete();
    }
}
