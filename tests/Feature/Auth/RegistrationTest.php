<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

$validPayload = fn () => [
    'name' => 'Jane Doe',
    'email' => 'jane@example.com',
    'password' => 'password123',
    'password_confirmation' => 'password123',
];

// ---------------------------------------------------------------------------
// Successful registration
// ---------------------------------------------------------------------------

it('creates a new user on valid registration', function () use ($validPayload) {
    $this->post('/register', $validPayload());

    $this->assertDatabaseHas('users', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
    ]);
});

it('authenticates the user after successful registration', function () use ($validPayload) {
    $this->post('/register', $validPayload());

    $this->assertAuthenticated();
});

it('redirects to /dashboard after successful registration', function () use ($validPayload) {
    $this->post('/register', $validPayload())
        ->assertRedirect('/dashboard');
});

// ---------------------------------------------------------------------------
// Validation — required fields
// ---------------------------------------------------------------------------

it('requires a name', function () use ($validPayload) {
    $this->post('/register', array_merge($validPayload(), ['name' => '']))
        ->assertSessionHasErrors('name');
});

it('requires an email', function () use ($validPayload) {
    $this->post('/register', array_merge($validPayload(), ['email' => '']))
        ->assertSessionHasErrors('email');
});

it('requires a password', function () use ($validPayload) {
    $this->post('/register', array_merge($validPayload(), ['password' => '', 'password_confirmation' => '']))
        ->assertSessionHasErrors('password');
});

// ---------------------------------------------------------------------------
// Validation — password
// ---------------------------------------------------------------------------

it('rejects a password below the minimum length', function () use ($validPayload) {
    $this->post('/register', array_merge($validPayload(), [
        'password' => 'short',
        'password_confirmation' => 'short',
    ]))->assertSessionHasErrors('password');
});

it('rejects a mismatched password confirmation', function () use ($validPayload) {
    $this->post('/register', array_merge($validPayload(), [
        'password_confirmation' => 'does-not-match',
    ]))->assertSessionHasErrors('password');
});

// ---------------------------------------------------------------------------
// Validation — email
// ---------------------------------------------------------------------------

it('rejects an email address already in use', function () use ($validPayload) {
    User::factory()->create(['email' => 'jane@example.com']);

    $this->post('/register', $validPayload())
        ->assertSessionHasErrors('email');
});

it('rejects a disposable email address', function () use ($validPayload) {
    $this->post('/register', array_merge($validPayload(), [
        'email' => 'jane@mailinator.com',
    ]))->assertSessionHasErrors('email');
});
