<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Forgot password
// ---------------------------------------------------------------------------

it('sends a reset link when the email exists', function () {
    Notification::fake();

    $user = User::factory()->create(['email' => 'jane@example.com']);

    $this->post('/forgot-password', ['email' => 'jane@example.com'])
        ->assertSessionHasNoErrors();

    Notification::assertSentTo($user, ResetPassword::class);
});

it('returns the same response for an unknown email — does not confirm the email is unknown', function () {
    Notification::fake();

    $this->post('/forgot-password', ['email' => 'nobody@example.com'])
        ->assertSessionHasErrors('email');

    Notification::assertNothingSent();
});

// ---------------------------------------------------------------------------
// Reset password
// ---------------------------------------------------------------------------

it('allows the customer to set a new password with a valid reset token', function () {
    $user = User::factory()->create(['email' => 'jane@example.com']);

    $token = Password::broker()->createToken($user);

    $this->post('/reset-password', [
        'token' => $token,
        'email' => 'jane@example.com',
        'password' => 'new-password123',
        'password_confirmation' => 'new-password123',
    ])->assertSessionHasNoErrors();

    expect(Hash::check('new-password123', $user->fresh()->password))->toBeTrue();
});

it('redirects to / after a successful password reset', function () {
    $user = User::factory()->create(['email' => 'jane@example.com']);

    $token = Password::broker()->createToken($user);

    $this->post('/reset-password', [
        'token' => $token,
        'email' => 'jane@example.com',
        'password' => 'new-password123',
        'password_confirmation' => 'new-password123',
    ])->assertRedirect(route('login'));
});

it('does not allow a password change with an invalid or expired token', function () {
    $user = User::factory()->create([
        'email' => 'jane@example.com',
        'password' => bcrypt('original-password'),
    ]);

    $this->post('/reset-password', [
        'token' => 'invalid-token',
        'email' => 'jane@example.com',
        'password' => 'new-password123',
        'password_confirmation' => 'new-password123',
    ])->assertSessionHasErrors('email');

    expect(Hash::check('original-password', $user->fresh()->password))->toBeTrue();
});

it('allows the customer to log in with the new password after a successful reset', function () {
    $user = User::factory()->create(['email' => 'jane@example.com']);

    $token = Password::broker()->createToken($user);

    $this->post('/reset-password', [
        'token' => $token,
        'email' => 'jane@example.com',
        'password' => 'new-password123',
        'password_confirmation' => 'new-password123',
    ]);

    $this->post('/login', [
        'email' => 'jane@example.com',
        'password' => 'new-password123',
    ]);

    $this->assertAuthenticated();
});
