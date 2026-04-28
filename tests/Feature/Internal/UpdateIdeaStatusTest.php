<?php

use App\Enums\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use App\Notifications\IdeaStatusChanged;
use Illuminate\Support\Facades\Notification;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('redirects guests to login', function () {
    $idea = Idea::factory()->for(User::factory())->create();

    $this->patch(route('internal.ideas.status.update', $idea), [
        'status' => IdeaStatus::Planned->value,
    ])->assertRedirect(route('login'));
});

it('returns 403 for non-team members', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($user)
        ->patch(route('internal.ideas.status.update', $idea), [
            'status' => IdeaStatus::Planned->value,
        ])
        ->assertForbidden();
});

it('updates the status and creates an audit row', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create(['status' => IdeaStatus::UnderReview]);

    $this->actingAs($teamUser)
        ->from(route('internal.ideas.show', $idea))
        ->patch(route('internal.ideas.status.update', $idea), [
            'status' => IdeaStatus::Planned->value,
            'message' => 'Targeting Q3.',
        ])
        ->assertRedirect(route('internal.ideas.show', $idea))
        ->assertSessionHas('status');

    $this->assertDatabaseHas('ideas', [
        'id' => $idea->id,
        'status' => IdeaStatus::Planned->value,
    ]);

    $this->assertDatabaseHas('idea_status_updates', [
        'idea_id' => $idea->id,
        'user_id' => $teamUser->id,
        'from_status' => IdeaStatus::UnderReview->value,
        'to_status' => IdeaStatus::Planned->value,
        'message' => 'Targeting Q3.',
    ]);
});

it('stores a null message when none is provided', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create(['status' => IdeaStatus::UnderReview]);

    $this->actingAs($teamUser)
        ->patch(route('internal.ideas.status.update', $idea), [
            'status' => IdeaStatus::Planned->value,
        ]);

    $this->assertDatabaseHas('idea_status_updates', [
        'idea_id' => $idea->id,
        'message' => null,
    ]);
});

it('rejects an unknown status', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($teamUser)
        ->patch(route('internal.ideas.status.update', $idea), [
            'status' => 'banana',
        ])
        ->assertSessionHasErrors('status');

    $this->assertDatabaseCount('idea_status_updates', 0);
});

it('rejects messages over 5000 characters', function () {
    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create();

    $this->actingAs($teamUser)
        ->patch(route('internal.ideas.status.update', $idea), [
            'status' => IdeaStatus::Planned->value,
            'message' => str_repeat('a', 5001),
        ])
        ->assertSessionHasErrors('message');

    $this->assertDatabaseCount('idea_status_updates', 0);
});

it('does not create a row or notify when the status is unchanged', function () {
    Notification::fake();

    $teamUser = User::factory()->teamMember()->create();
    $idea = Idea::factory()->for(User::factory())->create(['status' => IdeaStatus::Planned]);

    $this->actingAs($teamUser)
        ->patch(route('internal.ideas.status.update', $idea), [
            'status' => IdeaStatus::Planned->value,
            'message' => 'redundant',
        ])
        ->assertSessionHas('status');

    $this->assertDatabaseCount('idea_status_updates', 0);
    Notification::assertNothingSent();
});

it('notifies subscribers excluding the actor and includes the message', function () {
    Notification::fake();

    $author = User::factory()->create();
    $teamUser = User::factory()->teamMember()->create();
    $otherSubscriber = User::factory()->create();

    $idea = Idea::factory()->for($author)->create(['status' => IdeaStatus::UnderReview]);
    $idea->subscribers()->attach([$teamUser->id, $otherSubscriber->id]);

    $this->actingAs($teamUser)
        ->patch(route('internal.ideas.status.update', $idea), [
            'status' => IdeaStatus::Planned->value,
            'message' => 'Picked up this sprint.',
        ]);

    Notification::assertSentTo(
        $author,
        IdeaStatusChanged::class,
        fn ($notification) => $notification->statusUpdate->message === 'Picked up this sprint.'
            && $notification->statusUpdate->from_status === IdeaStatus::UnderReview
            && $notification->statusUpdate->to_status === IdeaStatus::Planned,
    );
    Notification::assertSentTo($otherSubscriber, IdeaStatusChanged::class);
    Notification::assertNotSentTo($teamUser, IdeaStatusChanged::class);
});
