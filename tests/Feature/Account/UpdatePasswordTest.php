<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Successful password change
// ---------------------------------------------------------------------------

it('allows a logged-in customer to change their password', function () {
    $user = User::factory()->create(['password' => 'old-password-123']);

    $this->actingAs($user)
        ->put('/account/password', [
            'current_password' => 'old-password-123',
            'password' => 'new-password-456',
            'password_confirmation' => 'new-password-456',
        ])
        ->assertSessionHasNoErrors();

    expect(Hash::check('new-password-456', $user->fresh()->password))->toBeTrue();
});

it('takes effect immediately — the customer can log in with the new password', function () {
    $user = User::factory()->create([
        'email' => 'user@example.com',
        'password' => 'old-password-123',
    ]);

    $this->actingAs($user)
        ->put('/account/password', [
            'current_password' => 'old-password-123',
            'password' => 'new-password-456',
            'password_confirmation' => 'new-password-456',
        ]);

    $this->post('/logout');

    $this->post('/login', [
        'email' => 'user@example.com',
        'password' => 'new-password-456',
    ]);

    $this->assertAuthenticated();
});

// ---------------------------------------------------------------------------
// Validation
// ---------------------------------------------------------------------------

it('returns a validation error when the current password is incorrect', function () {
    $user = User::factory()->create(['password' => 'old-password-123']);

    $this->actingAs($user)
        ->put('/account/password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password-456',
            'password_confirmation' => 'new-password-456',
        ])
        ->assertSessionHasErrors('current_password');
});

it('returns a validation error when the new password is below the minimum length', function () {
    $user = User::factory()->create(['password' => 'old-password-123']);

    $this->actingAs($user)
        ->put('/account/password', [
            'current_password' => 'old-password-123',
            'password' => 'short',
            'password_confirmation' => 'short',
        ])
        ->assertSessionHasErrors('password');
});

it('returns a validation error when the password confirmation does not match', function () {
    $user = User::factory()->create(['password' => 'old-password-123']);

    $this->actingAs($user)
        ->put('/account/password', [
            'current_password' => 'old-password-123',
            'password' => 'new-password-456',
            'password_confirmation' => 'something-else',
        ])
        ->assertSessionHasErrors('password');
});
