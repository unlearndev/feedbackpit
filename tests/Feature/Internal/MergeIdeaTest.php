<?php

use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('moves comments to the idea being kept', function () {
    $teamMember = User::factory()->create(['is_team_member' => true]);

    $duplicate = Idea::factory()->for(User::factory())->create();
    $keeper = Idea::factory()->for(User::factory())->create();

    $comment = Comment::factory()->for($duplicate)->for(User::factory())->create();

    $this->actingAs($teamMember)
        ->post("/internal/ideas/{$duplicate->id}/merge", [
            'target_id' => $keeper->id,
        ])
        ->assertRedirect("/internal/ideas/{$keeper->id}");

    expect($comment->fresh()->idea_id)->toBe($keeper->id);
    expect($duplicate->fresh()->merged_into_id)->toBe($keeper->id);
});
