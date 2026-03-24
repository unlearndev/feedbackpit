<?php

use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('never shows internal notes on the public idea detail page', function () {
    $idea = Idea::factory()->for(User::factory())->create();
    Comment::factory()->for($idea)->for(User::factory())->create(['is_internal' => true, 'body' => 'Secret note']);
    Comment::factory()->for($idea)->for(User::factory())->create(['is_internal' => false, 'body' => 'Public comment']);

    $this->get(route('feedback.show', $idea))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('comments', 1)
            ->where('comments.0.body', 'Public comment')
        );
});

it('hides internal notes from guests', function () {
    $idea = Idea::factory()->for(User::factory())->create();
    Comment::factory()->for($idea)->for(User::factory()->teamMember())->count(3)->create(['is_internal' => true]);

    $this->get(route('feedback.show', $idea))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('comments', 0)
        );
});

it('hides internal notes from regular authenticated users', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    Comment::factory()->for($idea)->for(User::factory()->teamMember())->count(2)->create(['is_internal' => true]);
    Comment::factory()->for($idea)->for(User::factory())->create(['is_internal' => false]);

    $this->actingAs($user)
        ->get(route('feedback.show', $idea))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('comments', 1)
        );
});
