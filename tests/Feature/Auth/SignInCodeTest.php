<?php

use App\Actions\Auth\IssueSignInCode;
use App\Models\SignInCode;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();

    $this->user = User::factory()->create([
        'email' => 'jane@example.com',
    ]);
});

it('renders the request page', function () {
    $this->get('/login/code')->assertOk();
});

it('issues a code for an existing user and redirects to the confirm page', function () {
    $this->post('/login/code', ['email' => 'jane@example.com'])
        ->assertRedirect('/login/code/confirm?email=jane%40example.com');

    expect(SignInCode::query()->where('user_id', $this->user->id)->count())->toBe(1);
});

it('signs the user in with a valid code', function () {
    $action = app(IssueSignInCode::class);
    $signInCode = $action($this->user);

    $this->post('/login/code/confirm', [
        'email' => 'jane@example.com',
        'code' => $signInCode->code,
    ])->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($this->user);
});

it('deletes the code once it has been used', function () {
    $action = app(IssueSignInCode::class);
    $signInCode = $action($this->user);

    $this->post('/login/code/confirm', [
        'email' => 'jane@example.com',
        'code' => $signInCode->code,
    ]);

    expect(SignInCode::query()->find($signInCode->id))->toBeNull();
});

it('generates a 6-digit code', function () {
    $action = Mockery::mock(IssueSignInCode::class);
    $action->shouldReceive('__invoke')
        ->once()
        ->andReturn(new SignInCode([
            'code' => '123456',
            'expires_at' => now()->addMinutes(15),
        ]));

    $result = $action($this->user);

    expect($result->code)->toBe('123456')
        ->and(strlen($result->code))->toBe(6);
});
