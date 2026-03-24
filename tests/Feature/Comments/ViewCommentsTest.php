<?php

use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('includes public comments on the idea detail page', function () {
    $idea = Idea::factory()->for(User::factory())->create();
    $comment = Comment::factory()->for($idea)->for(User::factory())->create(['body' => 'Visible comment']);

    $this->get(route('feedback.show', $idea))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Ideas/Show')
            ->has('comments', 1)
            ->where('comments.0.body', 'Visible comment')
        );
});

it('excludes internal comments from the public page', function () {
    $idea = Idea::factory()->for(User::factory())->create();
    Comment::factory()->for($idea)->for(User::factory())->create(['is_internal' => true]);
    Comment::factory()->for($idea)->for(User::factory())->create(['is_internal' => false]);

    $this->get(route('feedback.show', $idea))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('comments', 1)
        );
});

it('shows comments in chronological order', function () {
    $idea = Idea::factory()->for(User::factory())->create();

    Comment::factory()->for($idea)->for(User::factory())->create([
        'body' => 'First',
        'created_at' => now()->subDay(),
    ]);

    Comment::factory()->for($idea)->for(User::factory())->create([
        'body' => 'Second',
        'created_at' => now(),
    ]);

    $this->get(route('feedback.show', $idea))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('comments.0.body', 'First')
            ->where('comments.1.body', 'Second')
        );
});

it('includes the comment author name and team member flag', function () {
    $idea = Idea::factory()->for(User::factory())->create();
    $teamUser = User::factory()->teamMember()->create(['name' => 'Staff Person']);
    Comment::factory()->for($idea)->for($teamUser)->create();

    $this->get(route('feedback.show', $idea))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('comments.0.user.name', 'Staff Person')
            ->where('comments.0.user.is_team_member', true)
        );
});
