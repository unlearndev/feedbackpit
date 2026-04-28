<?php

use App\Enums\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use App\Notifications\IdeaStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('notifies all subscribers when status changes', function () {
    Notification::fake();

    $author = User::factory()->create();
    $voter = User::factory()->create();
    $idea = Idea::factory()->for($author)->create(['status' => IdeaStatus::UnderReview]);
    $idea->subscribers()->attach($voter);

    $idea->status = IdeaStatus::Planned;
    $idea->save();

    Notification::assertSentTo($author, IdeaStatusChanged::class);
    Notification::assertSentTo($voter, IdeaStatusChanged::class);
});

it('does not notify the actor performing the status change', function () {
    Notification::fake();

    $author = User::factory()->create();
    $teamMember = User::factory()->create(['is_team_member' => true]);
    $idea = Idea::factory()->for($author)->create(['status' => IdeaStatus::UnderReview]);
    $idea->subscribers()->attach($teamMember);

    $this->actingAs($teamMember);
    $idea->status = IdeaStatus::Planned;
    $idea->save();

    Notification::assertSentTo($author, IdeaStatusChanged::class);
    Notification::assertNotSentTo($teamMember, IdeaStatusChanged::class);
});

it('does not notify on non-status updates', function () {
    Notification::fake();

    $author = User::factory()->create();
    $idea = Idea::factory()->for($author)->create();

    $idea->update(['title' => 'Renamed title']);

    Notification::assertNothingSentTo($author);
});

it('passes the previous status to the notification', function () {
    Notification::fake();

    $author = User::factory()->create();
    $idea = Idea::factory()->for($author)->create(['status' => IdeaStatus::UnderReview]);

    $idea->status = IdeaStatus::Planned;
    $idea->save();

    Notification::assertSentTo(
        $author,
        IdeaStatusChanged::class,
        fn ($notification) => $notification->oldStatus === IdeaStatus::UnderReview
            && $notification->idea->status === IdeaStatus::Planned,
    );
});

it('queues the notification', function () {
    expect(is_subclass_of(IdeaStatusChanged::class, ShouldQueue::class))->toBeTrue();
});
