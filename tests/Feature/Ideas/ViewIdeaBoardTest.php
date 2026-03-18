<?php

use App\Models\Idea;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Board rendering
// ---------------------------------------------------------------------------

it('renders the home page with ideas', function () {
    $user = User::factory()->create();
    Idea::factory()->for($user)->create(['title' => 'My great idea']);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Home')
            ->has('ideas', 1)
            ->where('ideas.0.title', 'My great idea')
            ->where('ideas.0.user.name', $user->name)
        );
});

it('shows ideas newest first', function () {
    $user = User::factory()->create();
    $older = Idea::factory()->for($user)->create(['title' => 'Older idea', 'created_at' => now()->subDay()]);
    $newer = Idea::factory()->for($user)->create(['title' => 'Newer idea', 'created_at' => now()]);

    $this->get(route('home'))
        ->assertInertia(fn ($page) => $page
            ->where('ideas.0.title', 'Newer idea')
            ->where('ideas.1.title', 'Older idea')
        );
});

it('shows an empty state when no ideas exist', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Home')
            ->has('ideas', 0)
        );
});

it('includes the status for each idea', function () {
    Idea::factory()->for(User::factory())->create(['status' => 'planned']);

    $this->get(route('home'))
        ->assertInertia(fn ($page) => $page
            ->where('ideas.0.status', 'planned')
        );
});

it('includes the votes for each idea', function () {
    Idea::factory()->for(User::factory())->create(['votes' => 5]);

    $this->get(route('home'))
        ->assertInertia(fn ($page) => $page
            ->where('ideas.0.votes', 5)
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
        ->get(route('home'))
        ->assertInertia(fn ($page) => $page
            ->where('ideas.0.has_voted', true)
        );
});

it('includes has_voted as false when the user has not voted', function () {
    $user = User::factory()->create();
    Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->get(route('home'))
        ->assertInertia(fn ($page) => $page
            ->where('ideas.0.has_voted', false)
        );
});
