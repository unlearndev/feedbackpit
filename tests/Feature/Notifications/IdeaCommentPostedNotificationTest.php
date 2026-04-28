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

    Comment::factory()->for($idea)->for($teamMember)->create(['is_internal' => false]);

    Notification::assertSentTo($author, IdeaCommentPosted::class);
    Notification::assertSentTo($voter, IdeaCommentPosted::class);
});

it('does not notify the commenter themselves', function () {
    Notification::fake();

    $author = User::factory()->create();
    $teamMember = User::factory()->create(['is_team_member' => true]);
    $idea = Idea::factory()->for($author)->create();
    $idea->subscribers()->attach($teamMember);

    Comment::factory()->for($idea)->for($teamMember)->create(['is_internal' => false]);

    Notification::assertSentTo($author, IdeaCommentPosted::class);
    Notification::assertNotSentTo($teamMember, IdeaCommentPosted::class);
});

it('does not notify when the comment is internal', function () {
    Notification::fake();

    $author = User::factory()->create();
    $teamMember = User::factory()->create(['is_team_member' => true]);
    $idea = Idea::factory()->for($author)->create();

    Comment::factory()->for($idea)->for($teamMember)->internal()->create();

    Notification::assertNothingSentTo($author);
});

it('does not notify when a non-team-member customer comments', function () {
    Notification::fake();

    $author = User::factory()->create(['is_team_member' => false]);
    $otherCustomer = User::factory()->create(['is_team_member' => false]);
    $idea = Idea::factory()->for($author)->create();

    Comment::factory()->for($idea)->for($otherCustomer)->create(['is_internal' => false]);

    Notification::assertNothingSentTo($author);
});

it('auto-subscribes any public commenter, even non-team-members', function () {
    Notification::fake();

    $author = User::factory()->create();
    $otherCustomer = User::factory()->create(['is_team_member' => false]);
    $idea = Idea::factory()->for($author)->create();

    Comment::factory()->for($idea)->for($otherCustomer)->create(['is_internal' => false]);

    expect($idea->subscribers()->where('users.id', $otherCustomer->id)->exists())->toBeTrue();
});

it('does not auto-subscribe internal commenters', function () {
    $author = User::factory()->create();
    $teamMember = User::factory()->create(['is_team_member' => true]);
    $idea = Idea::factory()->for($author)->create();
    $idea->subscribers()->detach($teamMember->id);

    Comment::factory()->for($idea)->for($teamMember)->internal()->create();

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
