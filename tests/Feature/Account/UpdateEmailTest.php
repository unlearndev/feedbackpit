<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Auth guard
// ---------------------------------------------------------------------------

it('redirects a guest to the login page', function () {
    $this->get('/account/settings')->assertRedirect('/login');
    $this->put('/account/settings', ['email' => 'new@example.com'])->assertRedirect('/login');
});

// ---------------------------------------------------------------------------
// Page render
// ---------------------------------------------------------------------------

it('renders the account settings page for a logged-in user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/account/settings')
        ->assertOk();
});

// ---------------------------------------------------------------------------
// Successful email update
// ---------------------------------------------------------------------------

it('updates the email address to a valid unique address', function () {
    $user = User::factory()->create(['email' => 'old@example.com']);

    $this->actingAs($user)
        ->put('/account/settings', ['email' => 'new@example.com'])
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'email' => 'new@example.com',
    ]);
});

it('takes effect immediately — the customer can log in with the new email', function () {
    $user = User::factory()->create(['email' => 'old@example.com', 'password' => 'password123']);

    $this->actingAs($user)
        ->put('/account/settings', ['email' => 'new@example.com']);

    $this->post('/logout');

    $this->post('/login', [
        'email' => 'new@example.com',
        'password' => 'password123',
    ]);

    $this->assertAuthenticated();
});

// ---------------------------------------------------------------------------
// Validation
// ---------------------------------------------------------------------------

it('returns a validation error when the email is already in use', function () {
    User::factory()->create(['email' => 'taken@example.com']);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put('/account/settings', ['email' => 'taken@example.com'])
        ->assertSessionHasErrors('email');
});

it('returns a validation error for a disposable email domain', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put('/account/settings', ['email' => 'jane@mailinator.com'])
        ->assertSessionHasErrors('email');
});

it('returns a validation error for an invalid email format', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put('/account/settings', ['email' => 'not-an-email'])
        ->assertSessionHasErrors('email');
});
