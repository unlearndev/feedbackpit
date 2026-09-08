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

    $this->get(route('dashboard'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Dashboard')
            ->has('ideas.data', 1)
            ->where('ideas.data.0.title', 'My great idea')
            ->where('ideas.data.0.user.name', $user->name)
        );
});

it('shows the most voted ideas first', function () {
    $user = User::factory()->create();
    Idea::factory()->for($user)->create(['title' => 'Less popular idea', 'votes' => 2]);
    Idea::factory()->for($user)->create(['title' => 'Popular idea', 'votes' => 9]);

    $this->get(route('dashboard'))
        ->assertInertia(fn ($page) => $page
            ->where('ideas.data.0.title', 'Popular idea')
            ->where('ideas.data.1.title', 'Less popular idea')
        );
});

it('shows twelve ideas per page', function () {
    Idea::factory()->for(User::factory())->count(15)->create();

    $this->get(route('dashboard'))
        ->assertInertia(fn ($page) => $page
            ->has('ideas.data', 12)
            ->where('ideas.meta.last_page', 2)
        );

    $this->get(route('dashboard', ['page' => 2]))
        ->assertInertia(fn ($page) => $page
            ->has('ideas.data', 3)
        );
});

it('shows an empty state when no ideas exist', function () {
    $this->get(route('dashboard'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Dashboard')
            ->has('ideas.data', 0)
        );
});

it('includes the status for each idea', function () {
    Idea::factory()->for(User::factory())->create(['status' => 'planned']);

    $this->get(route('dashboard'))
        ->assertInertia(fn ($page) => $page
            ->where('ideas.data.0.status', 'planned')
        );
});

it('includes the votes for each idea', function () {
    Idea::factory()->for(User::factory())->create(['votes' => 5]);

    $this->get(route('dashboard'))
        ->assertInertia(fn ($page) => $page
            ->where('ideas.data.0.votes', 5)
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
        ->get(route('dashboard'))
        ->assertInertia(fn ($page) => $page
            ->where('ideas.data.0.has_voted', true)
        );
});

it('includes has_voted as false when the user has not voted', function () {
    $user = User::factory()->create();
    Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertInertia(fn ($page) => $page
            ->where('ideas.data.0.has_voted', false)
        );
});
