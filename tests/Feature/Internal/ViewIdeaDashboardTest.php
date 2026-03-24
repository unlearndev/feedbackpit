<?php

use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('redirects guests to login', function () {
    $this->get(route('internal.ideas.index'))
        ->assertRedirect(route('login'));
});

it('returns 403 for non-team members', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('internal.ideas.index'))
        ->assertForbidden();
});

it('shows ideas to team members', function () {
    $teamUser = User::factory()->teamMember()->create();
    Idea::factory()->for(User::factory())->count(3)->create();

    $this->actingAs($teamUser)
        ->get(route('internal.ideas.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Internal/Ideas/Index')
            ->has('ideas', 3)
        );
});

it('includes public comment counts', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    Comment::factory()->for($idea)->for(User::factory())->count(2)->create(['is_internal' => false]);
    Comment::factory()->for($idea)->for(User::factory())->create(['is_internal' => true]);

    $this->actingAs($teamUser)
        ->get(route('internal.ideas.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('ideas.0.comments_count', 2)
        );
});

it('shows ideas newest first', function () {
    $teamUser = User::factory()->teamMember()->create();

    Idea::factory()->for(User::factory())->create([
        'title' => 'Older',
        'created_at' => now()->subDay(),
    ]);

    Idea::factory()->for(User::factory())->create([
        'title' => 'Newer',
        'created_at' => now(),
    ]);

    $this->actingAs($teamUser)
        ->get(route('internal.ideas.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('ideas.0.title', 'Newer')
            ->where('ideas.1.title', 'Older')
        );
});
