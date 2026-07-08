<?php

use App\Models\Idea;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('redirects guests to login', function () {
    $idea = Idea::factory()->create();

    $this->delete(route('feedback.destroy', $idea))
        ->assertRedirect(route('login'));

    $this->assertDatabaseHas('ideas', ['id' => $idea->id]);
});

it('forbids a non-author from deleting', function () {
    $idea = Idea::factory()->create();

    $this->actingAs(User::factory()->create())
        ->delete(route('feedback.destroy', $idea))
        ->assertForbidden();

    $this->assertDatabaseHas('ideas', ['id' => $idea->id]);
});

it('deletes the idea for the author', function () {
    $idea = Idea::factory()->create();

    $this->actingAs($idea->user)
        ->delete(route('feedback.destroy', $idea))
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('status');

    $this->assertDatabaseMissing('ideas', ['id' => $idea->id]);
});
