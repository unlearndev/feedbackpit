<?php

use App\Models\Idea;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Authorization
// ---------------------------------------------------------------------------

it('redirects guests to login', function () {
    $idea = Idea::factory()->for(User::factory())->create();

    $this->post(route('feedback.react', $idea), ['emoji' => '🎉'])
        ->assertRedirect(route('login'));
});

// ---------------------------------------------------------------------------
// Reacting
// ---------------------------------------------------------------------------

it('allows an authenticated user to react', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->post(route('feedback.react', $idea), ['emoji' => '🚀']);

    $this->assertDatabaseHas('reactions', [
        'idea_id' => $idea->id,
        'user_id' => $user->id,
        'emoji' => '🚀',
    ]);
});

it('toggles the same reaction off on second click', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)->post(route('feedback.react', $idea), ['emoji' => '❤️']);
    $this->actingAs($user)->post(route('feedback.react', $idea), ['emoji' => '❤️']);

    $this->assertDatabaseMissing('reactions', [
        'idea_id' => $idea->id,
        'user_id' => $user->id,
        'emoji' => '❤️',
    ]);
});

it('lets a user add more than one different reaction', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)->post(route('feedback.react', $idea), ['emoji' => '👍']);
    $this->actingAs($user)->post(route('feedback.react', $idea), ['emoji' => '🎉']);

    expect($idea->reactions()->where('user_id', $user->id)->count())->toBe(2);
});

it('rejects an emoji that is not in the allowed set', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->post(route('feedback.react', $idea), ['emoji' => '💩'])
        ->assertSessionHasErrors('emoji');

    $this->assertDatabaseCount('reactions', 0);
});

it('redirects back after reacting', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->from(route('feedback.show', $idea))
        ->post(route('feedback.react', $idea), ['emoji' => '👀'])
        ->assertRedirect(route('feedback.show', $idea));
});
