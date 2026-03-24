<?php

use App\Models\Idea;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('redirects guests to login', function () {
    $idea = Idea::factory()->for(User::factory())->create();

    $this->post(route('internal.ideas.notes.store', $idea), ['body' => 'A note'])
        ->assertRedirect(route('login'));
});

it('returns 403 for non-team members', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->post(route('internal.ideas.notes.store', $idea), ['body' => 'Sneaky note'])
        ->assertForbidden();
});

it('allows team members to post an internal note', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($teamUser)
        ->post(route('internal.ideas.notes.store', $idea), ['body' => 'Internal thought']);

    $this->assertDatabaseHas('comments', [
        'idea_id' => $idea->id,
        'user_id' => $teamUser->id,
        'body' => 'Internal thought',
        'is_internal' => true,
    ]);
});

it('redirects back after posting a note', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($teamUser)
        ->from(route('internal.ideas.show', $idea))
        ->post(route('internal.ideas.notes.store', $idea), ['body' => 'Note'])
        ->assertRedirect(route('internal.ideas.show', $idea));
});

it('requires a body', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($teamUser)
        ->post(route('internal.ideas.notes.store', $idea), ['body' => ''])
        ->assertSessionHasErrors('body');
});

it('rejects a body longer than 5000 characters', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($teamUser)
        ->post(route('internal.ideas.notes.store', $idea), ['body' => str_repeat('a', 5001)])
        ->assertSessionHasErrors('body');
});
