<?php

use App\Enums\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use App\Notifications\IdeaStatusChanged;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('removes the subscription when a valid signed link is hit', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    $idea->subscribers()->attach($user);

    $url = URL::signedRoute('feedback.unsubscribe', ['idea' => $idea->id, 'user' => $user->id]);

    $this->get($url)->assertOk();

    expect($idea->subscribers()->where('users.id', $user->id)->exists())->toBeFalse();
});

it('renders the unsubscribed Inertia page', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    $idea->subscribers()->attach($user);

    $url = URL::signedRoute('feedback.unsubscribe', ['idea' => $idea->id, 'user' => $user->id]);

    $this->get($url)
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Ideas/Unsubscribed')
            ->where('idea.id', $idea->id),
        );
});

it('rejects an unsigned URL', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    $idea->subscribers()->attach($user);

    $this->get(route('feedback.unsubscribe', ['idea' => $idea, 'user' => $user], absolute: false))
        ->assertForbidden();

    expect($idea->subscribers()->where('users.id', $user->id)->exists())->toBeTrue();
});

it('rejects a tampered signature', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    $idea->subscribers()->attach($user);

    $url = URL::signedRoute('feedback.unsubscribe', ['idea' => $idea->id, 'user' => $user->id]).'tampered';

    $this->get($url)->assertForbidden();

    expect($idea->subscribers()->where('users.id', $user->id)->exists())->toBeTrue();
});

it('is idempotent', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    $idea->subscribers()->attach($user);

    $url = URL::signedRoute('feedback.unsubscribe', ['idea' => $idea->id, 'user' => $user->id]);

    $this->get($url)->assertOk();
    $this->get($url)->assertOk();

    expect($idea->subscribers()->where('users.id', $user->id)->exists())->toBeFalse();
});

it('does not require authentication', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    $idea->subscribers()->attach($user);

    $url = URL::signedRoute('feedback.unsubscribe', ['idea' => $idea->id, 'user' => $user->id]);

    $this->get($url)->assertOk();
});

it('only unsubscribes the specified user from the specified idea', function () {
    Notification::fake();

    $teamUser = User::factory()->teamMember()->create();
    $userA = User::factory()->create();
    $userB = User::factory()->create();
    $ideaOne = Idea::factory()->for(User::factory())->create(['status' => IdeaStatus::UnderReview]);
    $ideaTwo = Idea::factory()->for(User::factory())->create(['status' => IdeaStatus::UnderReview]);
    $ideaOne->subscribers()->attach([$userA->id, $userB->id]);
    $ideaTwo->subscribers()->attach($userA);

    $url = URL::signedRoute('feedback.unsubscribe', ['idea' => $ideaOne->id, 'user' => $userA->id]);
    $this->get($url)->assertOk();

    expect($ideaOne->subscribers()->where('users.id', $userA->id)->exists())->toBeFalse();
    expect($ideaOne->subscribers()->where('users.id', $userB->id)->exists())->toBeTrue();
    expect($ideaTwo->subscribers()->where('users.id', $userA->id)->exists())->toBeTrue();

    $this->actingAs($teamUser)
        ->patch(route('internal.ideas.status.update', $ideaOne), [
            'status' => IdeaStatus::Planned->value,
        ]);

    Notification::assertSentTo($userB, IdeaStatusChanged::class);
    Notification::assertNotSentTo($userA, IdeaStatusChanged::class);
});
