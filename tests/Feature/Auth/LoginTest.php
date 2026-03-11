<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Login
// ---------------------------------------------------------------------------

describe('login', function () {
    beforeEach(function () {
        $this->user = User::factory()->create([
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
        ]);
    });

    it('authenticates the customer on valid credentials', function () {
        $this->post('/login', [
            'email' => 'jane@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
    });

    it('redirects to / after successful login', function () {
        $this->post('/login', [
            'email' => 'jane@example.com',
            'password' => 'password123',
        ])->assertRedirect('/');
    });

    it('returns a validation error on incorrect password', function () {
        $this->post('/login', [
            'email' => 'jane@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    });

    it('returns the same generic validation error when the email does not exist', function () {
        $this->post('/login', [
            'email' => 'nobody@example.com',
            'password' => 'password123',
        ])->assertSessionHasErrors('email');
    });

    it('does not authenticate after a failed login attempt', function () {
        $this->post('/login', [
            'email' => 'jane@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    });
});

// ---------------------------------------------------------------------------
// Logout
// ---------------------------------------------------------------------------

describe('logout', function () {
    it('unauthenticates the customer after logout', function () {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout');

        $this->assertGuest();
    });

    it('redirects to / after logout', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/');
    });

    it('does not cause an error when a guest posts to the logout endpoint', function () {
        $this->post('/logout')
            ->assertRedirect();
    });
});
