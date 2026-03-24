<?php

use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('redirects guests to login', function () {
    $idea = Idea::factory()->for(User::factory())->create();

    $this->get(route('internal.ideas.show', $idea))
        ->assertRedirect(route('login'));
});

it('returns 403 for non-team members', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->get(route('internal.ideas.show', $idea))
        ->assertForbidden();
});

it('shows the idea detail to team members', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($teamUser)
        ->get(route('internal.ideas.show', $idea))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Internal/Ideas/Show')
            ->where('idea.title', $idea->title)
        );
});

it('includes public comments', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    Comment::factory()->for($idea)->for(User::factory())->create(['is_internal' => false, 'body' => 'Public one']);

    $this->actingAs($teamUser)
        ->get(route('internal.ideas.show', $idea))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('comments', 1)
            ->where('comments.0.body', 'Public one')
        );
});

it('includes internal comments separately', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    Comment::factory()->for($idea)->for(User::factory())->create(['is_internal' => false]);
    Comment::factory()->for($idea)->for(User::factory())->create(['is_internal' => true, 'body' => 'Internal note']);

    $this->actingAs($teamUser)
        ->get(route('internal.ideas.show', $idea))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('comments', 1)
            ->has('internalComments', 1)
            ->where('internalComments.0.body', 'Internal note')
        );
});

it('allows team members to post a public comment', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($teamUser)
        ->post(route('internal.ideas.comments.store', $idea), ['body' => 'Staff reply']);

    $this->assertDatabaseHas('comments', [
        'idea_id' => $idea->id,
        'user_id' => $teamUser->id,
        'body' => 'Staff reply',
        'is_internal' => false,
    ]);
});

it('redirects back after posting a comment', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($teamUser)
        ->from(route('internal.ideas.show', $idea))
        ->post(route('internal.ideas.comments.store', $idea), ['body' => 'Reply'])
        ->assertRedirect(route('internal.ideas.show', $idea));
});

it('blocks non-team members from posting via internal route', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->post(route('internal.ideas.comments.store', $idea), ['body' => 'Sneaky'])
        ->assertForbidden();
});
