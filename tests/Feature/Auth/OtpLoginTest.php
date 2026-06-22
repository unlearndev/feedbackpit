<?php

use App\Mail\LoginCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Requesting a code
// ---------------------------------------------------------------------------

it('shows the code request page', function () {
    $this->get('/login/code')->assertOk();
});

it('sends a sign-in code to an existing user', function () {
    Mail::fake();

    $user = User::factory()->create(['email' => 'jane@example.com']);

    $this->post('/login/code', ['email' => 'jane@example.com'])
        ->assertRedirect('/login/code/verify');

    $this->assertDatabaseHas('login_codes', ['user_id' => $user->id]);

    Mail::assertSent(LoginCodeMail::class);
});

it('requires an email to request a code', function () {
    $this->post('/login/code', ['email' => ''])
        ->assertSessionHasErrors('email');
});

// ---------------------------------------------------------------------------
// Verifying a code
// ---------------------------------------------------------------------------

it('signs the user in with a valid code', function () {
    $user = User::factory()->create(['email' => 'jane@example.com']);

    $user->loginCodes()->create([
        'code' => '123456',
        'expires_at' => now()->addMinutes(15),
    ]);

    $this->post('/login/code/verify', [
        'email' => 'jane@example.com',
        'code' => '123456',
    ])->assertRedirect('/dashboard');

    $this->assertAuthenticated();
});

it('rejects an incorrect code', function () {
    $user = User::factory()->create(['email' => 'jane@example.com']);

    $user->loginCodes()->create([
        'code' => '123456',
        'expires_at' => now()->addMinutes(15),
    ]);

    $this->post('/login/code/verify', [
        'email' => 'jane@example.com',
        'code' => '000000',
    ])->assertSessionHasErrors('code');

    $this->assertGuest();
});

it('requires a code to verify', function () {
    $this->post('/login/code/verify', ['email' => 'jane@example.com', 'code' => ''])
        ->assertSessionHasErrors('code');
});
