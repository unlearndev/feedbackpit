<?php

use App\Models\Idea;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Page rendering
// ---------------------------------------------------------------------------

it('renders the idea detail page', function () {
    $idea = Idea::factory()->for(User::factory())->create();

    $this->get(route('feedback.show', $idea))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Ideas/Show')
            ->has('idea')
        );
});

it('is accessible to guests', function () {
    $idea = Idea::factory()->for(User::factory())->create();

    $this->get(route('feedback.show', $idea))
        ->assertOk();
});

it('returns 404 for a non-existent idea', function () {
    $this->get('/feedback/99999')
        ->assertNotFound();
});

// ---------------------------------------------------------------------------
// Idea data
// ---------------------------------------------------------------------------

it('includes the idea author name', function () {
    $user = User::factory()->create(['name' => 'Jane Doe']);
    $idea = Idea::factory()->for($user)->create();

    $this->get(route('feedback.show', $idea))
        ->assertInertia(fn ($page) => $page
            ->where('idea.user.name', 'Jane Doe')
        );
});

it('includes the full description', function () {
    $description = 'This is the full description of the idea with lots of detail.';
    $idea = Idea::factory()->for(User::factory())->create(['description' => $description]);

    $this->get(route('feedback.show', $idea))
        ->assertInertia(fn ($page) => $page
            ->where('idea.description', $description)
        );
});

it('includes the status', function () {
    $idea = Idea::factory()->for(User::factory())->create(['status' => 'planned']);

    $this->get(route('feedback.show', $idea))
        ->assertInertia(fn ($page) => $page
            ->where('idea.status', 'planned')
        );
});

it('includes the vote count', function () {
    $idea = Idea::factory()->for(User::factory())->create(['votes' => 12]);

    $this->get(route('feedback.show', $idea))
        ->assertInertia(fn ($page) => $page
            ->where('idea.votes', 12)
        );
});

// ---------------------------------------------------------------------------
// Vote status
// ---------------------------------------------------------------------------

it('includes has_voted as true when the user has voted', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    $idea->voters()->attach($user);

    $this->actingAs($user)
        ->get(route('feedback.show', $idea))
        ->assertInertia(fn ($page) => $page
            ->where('idea.has_voted', true)
        );
});

it('includes has_voted as false when the user has not voted', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->get(route('feedback.show', $idea))
        ->assertInertia(fn ($page) => $page
            ->where('idea.has_voted', false)
        );
});
