<?php

use App\Enums\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use App\Notifications\IdeaStatusChanged;
use Illuminate\Support\Facades\Notification;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Auth guard
// ---------------------------------------------------------------------------

it('redirects a guest to the login page', function () {
    $idea = Idea::factory()->for(User::factory())->create();

    $this->get('/account/notifications')->assertRedirect('/login');
    $this->post('/account/notifications/'.$idea->id)->assertRedirect('/login');
    $this->delete('/account/notifications/'.$idea->id)->assertRedirect('/login');
});

// ---------------------------------------------------------------------------
// Listing
// ---------------------------------------------------------------------------

it('renders the notifications page with only the user\'s subscribed ideas', function () {
    $user = User::factory()->create();
    $subscribed = Idea::factory()->for(User::factory())->create();
    Idea::factory()->for(User::factory())->create();
    $subscribed->subscribers()->attach($user);

    $this->actingAs($user)
        ->get('/account/notifications')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Account/Notifications')
            ->has('ideas', 1)
            ->where('ideas.0.id', $subscribed->id)
            ->where('ideas.0.title', $subscribed->title)
        );
});

// ---------------------------------------------------------------------------
// Unsubscribe
// ---------------------------------------------------------------------------

it('detaches the current user from the idea', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    $idea->subscribers()->attach($user);

    $this->actingAs($user)
        ->from(route('account.notifications.edit'))
        ->delete('/account/notifications/'.$idea->id)
        ->assertRedirect(route('account.notifications.edit'));

    expect($idea->subscribers()->where('users.id', $user->id)->exists())->toBeFalse();
});

it('only detaches the current user, leaving other subscribers intact', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();
    $ideaOne = Idea::factory()->for(User::factory())->create();
    $ideaTwo = Idea::factory()->for(User::factory())->create();
    $ideaOne->subscribers()->attach([$userA->id, $userB->id]);
    $ideaTwo->subscribers()->attach($userA);

    $this->actingAs($userA)
        ->from(route('account.notifications.edit'))
        ->delete('/account/notifications/'.$ideaOne->id)
        ->assertRedirect(route('account.notifications.edit'));

    expect($ideaOne->subscribers()->where('users.id', $userA->id)->exists())->toBeFalse();
    expect($ideaOne->subscribers()->where('users.id', $userB->id)->exists())->toBeTrue();
    expect($ideaTwo->subscribers()->where('users.id', $userA->id)->exists())->toBeTrue();
});

it('detach is idempotent when the user was not subscribed', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->from(route('account.notifications.edit'))
        ->delete('/account/notifications/'.$idea->id)
        ->assertRedirect(route('account.notifications.edit'));

    expect($idea->subscribers()->where('users.id', $user->id)->exists())->toBeFalse();
});

// ---------------------------------------------------------------------------
// Subscribe
// ---------------------------------------------------------------------------

it('attaches the current user to the idea', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->from(route('feedback.show', $idea))
        ->post('/account/notifications/'.$idea->id)
        ->assertRedirect(route('feedback.show', $idea));

    expect($idea->subscribers()->where('users.id', $user->id)->exists())->toBeTrue();
});

it('subscribe is idempotent when the user is already subscribed', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();
    $idea->subscribers()->attach($user);

    $this->actingAs($user)
        ->from(route('feedback.show', $idea))
        ->post('/account/notifications/'.$idea->id)
        ->assertRedirect(route('feedback.show', $idea));

    expect($idea->subscribers()->where('users.id', $user->id)->count())->toBe(1);
});

it('exposes is_subscribed on the idea detail page', function () {
    $user = User::factory()->create();
    $subscribedIdea = Idea::factory()->for(User::factory())->create();
    $unrelatedIdea = Idea::factory()->for(User::factory())->create();
    $subscribedIdea->subscribers()->attach($user);

    $this->actingAs($user)
        ->get(route('feedback.show', $subscribedIdea))
        ->assertInertia(fn ($page) => $page->where('idea.is_subscribed', true));

    $this->actingAs($user)
        ->get(route('feedback.show', $unrelatedIdea))
        ->assertInertia(fn ($page) => $page->where('idea.is_subscribed', false));
});

it('reports is_subscribed as false for guests', function () {
    $idea = Idea::factory()->for(User::factory())->create();

    $this->get(route('feedback.show', $idea))
        ->assertInertia(fn ($page) => $page->where('idea.is_subscribed', false));
});

// ---------------------------------------------------------------------------
// Notification suppression
// ---------------------------------------------------------------------------

it('stops sending status-change emails after unsubscribing', function () {
    Notification::fake();

    $teamUser = User::factory()->teamMember()->create();
    $userA = User::factory()->create();
    $userB = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create(['status' => IdeaStatus::UnderReview]);
    $idea->subscribers()->attach([$userA->id, $userB->id]);

    $this->actingAs($userA)
        ->delete('/account/notifications/'.$idea->id);

    $this->actingAs($teamUser)
        ->patch(route('internal.ideas.status.update', $idea), [
            'status' => IdeaStatus::Planned->value,
        ]);

    Notification::assertSentTo($userB, IdeaStatusChanged::class);
    Notification::assertNotSentTo($userA, IdeaStatusChanged::class);
});
