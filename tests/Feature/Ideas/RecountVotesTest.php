<?php

use App\Models\Idea;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('corrects a vote count that has drifted from the voters', function () {
    $idea = Idea::factory()->for(User::factory())->create(['votes' => 7]);

    $idea->voters()->attach(User::factory()->count(3)->create());

    $this->artisan('votes:recount')->assertSuccessful();

    expect($idea->fresh()->votes)->toBe(3);
});

it('leaves a correct vote count alone', function () {
    $idea = Idea::factory()->for(User::factory())->create(['votes' => 2]);

    $idea->voters()->attach(User::factory()->count(2)->create());

    $this->artisan('votes:recount')->assertSuccessful();

    expect($idea->fresh()->votes)->toBe(2);
});
