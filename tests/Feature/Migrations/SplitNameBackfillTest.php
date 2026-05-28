<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('migrate:rollback', ['--step' => 1])->run();

    expect(Schema::hasColumn('users', 'name'))->toBeTrue();
    expect(Schema::hasColumn('users', 'first_name'))->toBeFalse();
    expect(Schema::hasColumn('users', 'last_name'))->toBeFalse();
});

it('splits a two-word legacy name on the first whitespace', function () {
    DB::table('users')->insert([
        'name' => 'Ada Lovelace',
        'email' => 'ada@example.com',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->artisan('migrate')->run();

    $row = DB::table('users')->where('email', 'ada@example.com')->first();

    expect($row->first_name)->toBe('Ada');
    expect($row->last_name)->toBe('Lovelace');
});

it('keeps everything after the first whitespace as the last name for multi-word legacy names', function () {
    DB::table('users')->insert([
        'name' => 'Mary Anne Smith',
        'email' => 'mary@example.com',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->artisan('migrate')->run();

    $row = DB::table('users')->where('email', 'mary@example.com')->first();

    expect($row->first_name)->toBe('Mary');
    expect($row->last_name)->toBe('Anne Smith');
});

it('leaves last_name empty when the legacy name is a single word', function () {
    DB::table('users')->insert([
        'name' => 'Cher',
        'email' => 'cher@example.com',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->artisan('migrate')->run();

    $row = DB::table('users')->where('email', 'cher@example.com')->first();

    expect($row->first_name)->toBe('Cher');
    expect($row->last_name)->toBe('');
});
