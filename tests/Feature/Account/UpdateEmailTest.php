<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Auth guard
// ---------------------------------------------------------------------------

$validPayload = fn (array $overrides = []) => array_merge([
    'first_name' => 'Jane',
    'last_name' => 'Doe',
    'email' => 'new@example.com',
], $overrides);

it('redirects a guest to the login page', function () use ($validPayload) {
    $this->get('/account/settings')->assertRedirect('/login');
    $this->put('/account/settings', $validPayload())->assertRedirect('/login');
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

it('updates the email address to a valid unique address', function () use ($validPayload) {
    $user = User::factory()->create(['email' => 'old@example.com']);

    $this->actingAs($user)
        ->put('/account/settings', $validPayload())
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'email' => 'new@example.com',
    ]);
});

it('takes effect immediately — the customer can log in with the new email', function () use ($validPayload) {
    $user = User::factory()->create(['email' => 'old@example.com', 'password' => 'password123']);

    $this->actingAs($user)
        ->put('/account/settings', $validPayload());

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

it('returns a validation error when the email is already in use', function () use ($validPayload) {
    User::factory()->create(['email' => 'taken@example.com']);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put('/account/settings', $validPayload(['email' => 'taken@example.com']))
        ->assertSessionHasErrors('email');
});

it('returns a validation error for a disposable email domain', function () use ($validPayload) {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put('/account/settings', $validPayload(['email' => 'jane@mailinator.com']))
        ->assertSessionHasErrors('email');
});

it('returns a validation error for an invalid email format', function () use ($validPayload) {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put('/account/settings', $validPayload(['email' => 'not-an-email']))
        ->assertSessionHasErrors('email');
});
