<?php

use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use App\Notifications\IdeaCommentPosted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('notifies all subscribers when a team member posts a public comment', function () {
    Notification::fake();

    $author = User::factory()->create();
    $voter = User::factory()->create();
    $teamMember = User::factory()->create(['is_team_member' => true]);
    $idea = Idea::factory()->for($author)->create();
    $idea->subscribers()->attach($voter);

    $this->actingAs($teamMember)
        ->post(route('internal.ideas.comments.store', $idea), ['body' => 'Thanks for the feedback!']);

    Notification::assertSentTo($author, IdeaCommentPosted::class);
    Notification::assertSentTo($voter, IdeaCommentPosted::class);
});

it('does not notify the commenter themselves', function () {
    Notification::fake();

    $author = User::factory()->create();
    $teamMember = User::factory()->create(['is_team_member' => true]);
    $idea = Idea::factory()->for($author)->create();
    $idea->subscribers()->attach($teamMember);

    $this->actingAs($teamMember)
        ->post(route('internal.ideas.comments.store', $idea), ['body' => 'Looking into this.']);

    Notification::assertSentTo($author, IdeaCommentPosted::class);
    Notification::assertNotSentTo($teamMember, IdeaCommentPosted::class);
});

it('does not notify when the comment is internal', function () {
    Notification::fake();

    $author = User::factory()->create();
    $teamMember = User::factory()->create(['is_team_member' => true]);
    $idea = Idea::factory()->for($author)->create();

    $this->actingAs($teamMember)
        ->post(route('internal.ideas.notes.store', $idea), ['body' => 'Private note.']);

    Notification::assertNothingSentTo($author);
});

it('does not notify when a non-team-member customer comments', function () {
    Notification::fake();

    $author = User::factory()->create(['is_team_member' => false]);
    $otherCustomer = User::factory()->create(['is_team_member' => false]);
    $idea = Idea::factory()->for($author)->create();

    $this->actingAs($otherCustomer)
        ->post(route('feedback.comments.store', $idea), ['body' => '+1 from me.']);

    Notification::assertNothingSentTo($author);
});

it('auto-subscribes any public commenter, even non-team-members', function () {
    Notification::fake();

    $author = User::factory()->create();
    $otherCustomer = User::factory()->create(['is_team_member' => false]);
    $idea = Idea::factory()->for($author)->create();

    $this->actingAs($otherCustomer)
        ->post(route('feedback.comments.store', $idea), ['body' => '+1 from me.']);

    expect($idea->subscribers()->where('users.id', $otherCustomer->id)->exists())->toBeTrue();
});

it('does not auto-subscribe internal commenters', function () {
    $author = User::factory()->create();
    $teamMember = User::factory()->create(['is_team_member' => true]);
    $idea = Idea::factory()->for($author)->create();
    $idea->subscribers()->detach($teamMember->id);

    $this->actingAs($teamMember)
        ->post(route('internal.ideas.notes.store', $idea), ['body' => 'Private note.']);

    expect($idea->subscribers()->where('users.id', $teamMember->id)->exists())->toBeFalse();
});

it('truncates long comment bodies in the email', function () {
    $author = User::factory()->create();
    $teamMember = User::factory()->create(['is_team_member' => true]);
    $idea = Idea::factory()->for($author)->create();

    $comment = Comment::factory()->for($idea)->for($teamMember)->make([
        'body' => str_repeat('a', 500),
        'is_internal' => false,
    ]);

    $mail = (new IdeaCommentPosted($comment))->toMail($author);
    $excerpt = $mail->viewData['excerpt'];

    expect(strlen($excerpt))->toBeLessThan(500);
    expect($excerpt)->toEndWith('...');
});

it('queues the notification', function () {
    expect(is_subclass_of(IdeaCommentPosted::class, ShouldQueue::class))->toBeTrue();
});
