<?php

use App\Http\Middleware\EnsureTeamMember;
use App\Models\User;
use Illuminate\Support\Facades\Route;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Route::middleware(['web', EnsureTeamMember::class])
        ->get('/test-team-route', fn () => 'ok')
        ->name('test.team');
});

it('redirects guests to login', function () {
    $this->get('/test-team-route')
        ->assertRedirect(route('login'));
});

it('returns 403 for non-team members', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/test-team-route')
        ->assertForbidden();
});

it('allows team members through', function () {
    $user = User::factory()->teamMember()->create();

    $this->actingAs($user)
        ->get('/test-team-route')
        ->assertOk();
});
