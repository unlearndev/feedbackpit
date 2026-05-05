<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Auth guard
// ---------------------------------------------------------------------------

it('redirects a guest to the login page', function () {
    $this->delete('/account', ['password' => 'password'])->assertRedirect('/login');
});

// ---------------------------------------------------------------------------
// Successful deletion
// ---------------------------------------------------------------------------

it('deletes the account when the password is correct', function () {
    $user = User::factory()->create(['password' => 'password123']);

    $this->actingAs($user)
        ->delete('/account', ['password' => 'password123'])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('landing'));

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

it('logs the user out after deletion', function () {
    $user = User::factory()->create(['password' => 'password123']);

    $this->actingAs($user)
        ->delete('/account', ['password' => 'password123']);

    $this->assertGuest();
});

it('cascades deletion of the user\'s ideas', function () {
    $user = User::factory()->create(['password' => 'password123']);
    $idea = $user->ideas()->save(\App\Models\Idea::factory()->make());

    $this->actingAs($user)
        ->delete('/account', ['password' => 'password123']);

    $this->assertDatabaseMissing('ideas', ['id' => $idea->id]);
});

// ---------------------------------------------------------------------------
// Validation
// ---------------------------------------------------------------------------

it('returns a validation error when the password is incorrect', function () {
    $user = User::factory()->create(['password' => 'password123']);

    $this->actingAs($user)
        ->delete('/account', ['password' => 'wrong-password'])
        ->assertSessionHasErrors('password');

    $this->assertDatabaseHas('users', ['id' => $user->id]);
});

it('returns a validation error when the password is missing', function () {
    $user = User::factory()->create(['password' => 'password123']);

    $this->actingAs($user)
        ->delete('/account', [])
        ->assertSessionHasErrors('password');

    $this->assertDatabaseHas('users', ['id' => $user->id]);
});
