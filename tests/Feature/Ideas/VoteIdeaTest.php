<?php

use App\Models\Idea;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Authorization
// ---------------------------------------------------------------------------

it('redirects guests to login', function () {
    $idea = Idea::factory()->for(User::factory())->create();

    $this->post(route('feedback.vote', $idea))
        ->assertRedirect(route('login'));
});

// ---------------------------------------------------------------------------
// Voting
// ---------------------------------------------------------------------------

it('allows an authenticated user to vote', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create(['votes' => 0]);

    $this->actingAs($user)
        ->post(route('feedback.vote', $idea));

    $this->assertDatabaseHas('idea_vote', [
        'idea_id' => $idea->id,
        'user_id' => $user->id,
    ]);

    expect($idea->fresh()->votes)->toBe(1);
});

it('removes the vote when voting again', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create(['votes' => 1]);

    // Seed existing vote
    $idea->voters()->attach($user);

    $this->actingAs($user)
        ->post(route('feedback.vote', $idea));

    $this->assertDatabaseMissing('idea_vote', [
        'idea_id' => $idea->id,
        'user_id' => $user->id,
    ]);

    expect($idea->fresh()->votes)->toBe(0);
});

it('toggles an existing vote off on second click', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create(['votes' => 0]);

    // Vote twice
    $this->actingAs($user)->post(route('feedback.vote', $idea));
    $this->actingAs($user)->post(route('feedback.vote', $idea));

    // Second click should toggle off, not create a duplicate
    $this->assertDatabaseMissing('idea_vote', [
        'idea_id' => $idea->id,
        'user_id' => $user->id,
    ]);

    expect($idea->fresh()->votes)->toBe(0);
});

it('redirects back after voting', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->from(route('feedback.show', $idea))
        ->post(route('feedback.vote', $idea))
        ->assertRedirect(route('feedback.show', $idea));
});

it('subscribes the voter to notifications when they vote', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)->post(route('feedback.vote', $idea));

    expect($idea->subscribers()->where('users.id', $user->id)->exists())->toBeTrue();
});

it('keeps the subscription when the voter unvotes', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    $idea->voters()->attach($user);
    $idea->subscribers()->attach($user);

    $this->actingAs($user)->post(route('feedback.vote', $idea));

    expect($idea->subscribers()->where('users.id', $user->id)->exists())->toBeTrue();
});
