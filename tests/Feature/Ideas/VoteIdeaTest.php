<?php

use App\Models\Idea;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Authorization
// ---------------------------------------------------------------------------

it('redirects guests to login', function () {
    $idea = Idea::factory()->for(User::factory())->create();

    $this->post(route('ideas.vote', $idea))
        ->assertRedirect(route('login'));
});

// ---------------------------------------------------------------------------
// Voting
// ---------------------------------------------------------------------------

it('allows an authenticated user to vote', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create(['votes' => 0]);

    $this->actingAs($user)
        ->post(route('ideas.vote', $idea));

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
        ->post(route('ideas.vote', $idea));

    $this->assertDatabaseMissing('idea_vote', [
        'idea_id' => $idea->id,
        'user_id' => $user->id,
    ]);

    expect($idea->fresh()->votes)->toBe(0);
});

it('does not allow duplicate votes', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create(['votes' => 0]);

    // Vote twice
    $this->actingAs($user)->post(route('ideas.vote', $idea));
    $this->actingAs($user)->post(route('ideas.vote', $idea));

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
        ->from(route('ideas.show', $idea))
        ->post(route('ideas.vote', $idea))
        ->assertRedirect(route('ideas.show', $idea));
});
