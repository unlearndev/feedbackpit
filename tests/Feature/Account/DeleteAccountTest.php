<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('allows a logged-in user to delete their account', function () {
    $user = User::factory()->create(['password' => 'old-password-123']);

    $this->actingAs($user)
        ->delete('/account', [
            'current_password' => 'old-password-123',
        ])
        ->assertRedirect('/');

    expect(User::find($user->id))->toBeNull();
    $this->assertGuest();
});

it('returns a validation error when the current password is incorrect', function () {
    $user = User::factory()->create(['password' => 'old-password-123']);

    $this->actingAs($user)
        ->delete('/account', [
            'current_password' => 'wrong-password',
        ])
        ->assertSessionHasErrors('current_password');

    expect(User::find($user->id))->not->toBeNull();
    $this->assertAuthenticated();
});

it('returns a validation error when the current password is missing', function () {
    $user = User::factory()->create(['password' => 'old-password-123']);

    $this->actingAs($user)
        ->delete('/account', [])
        ->assertSessionHasErrors('current_password');

    expect(User::find($user->id))->not->toBeNull();
});

it('requires authentication', function () {
    $this->delete('/account', [
        'current_password' => 'whatever',
    ])->assertRedirect('/login');
});
