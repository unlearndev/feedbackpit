<?php

use App\Models\Idea;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('redirects guests to login', function () {
    $idea = Idea::factory()->for(User::factory())->create();

    $this->post(route('feedback.comments.store', $idea), ['body' => 'A comment'])
        ->assertRedirect(route('login'));
});

it('stores a public comment', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->post(route('feedback.comments.store', $idea), ['body' => 'Great idea!']);

    $this->assertDatabaseHas('comments', [
        'idea_id' => $idea->id,
        'user_id' => $user->id,
        'body' => 'Great idea!',
        'is_internal' => false,
    ]);
});

it('redirects back after posting', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->from(route('feedback.show', $idea))
        ->post(route('feedback.comments.store', $idea), ['body' => 'Nice!'])
        ->assertRedirect(route('feedback.show', $idea));
});

it('requires a body', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->post(route('feedback.comments.store', $idea), ['body' => ''])
        ->assertSessionHasErrors('body');
});

it('rejects a body longer than 5000 characters', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->post(route('feedback.comments.store', $idea), ['body' => str_repeat('a', 5001)])
        ->assertSessionHasErrors('body');
});
