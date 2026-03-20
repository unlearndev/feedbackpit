<?php

namespace Database\Seeders;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        Idea::query()->delete();
        User::query()->delete();

        $users = collect([
            ['name' => 'Sarah Chen', 'email' => 'sarah@example.com'],
            ['name' => 'Marcus Johnson', 'email' => 'marcus@example.com'],
            ['name' => 'Emily Rivera', 'email' => 'emily@example.com'],
            ['name' => 'David Kim', 'email' => 'david@example.com'],
            ['name' => 'Rachel Foster', 'email' => 'rachel@example.com'],
        ])->map(fn (array $data) => User::create([
            ...$data,
            'password' => 'password',
        ]));

        $ideas = [
            [
                'title' => 'Dark mode support',
                'description' => 'It would be great to have a dark mode toggle. I often work late and the bright white background is tough on the eyes.',
                'status' => 'completed',
                'user' => 0,
                'voters' => [1, 2, 3, 4],
            ],
            [
                'title' => 'Email notifications when status changes',
                'description' => 'I want to know when my feedback moves from Under Review to Planned or In Progress. A simple email notification would be perfect.',
                'status' => 'in_progress',
                'user' => 1,
                'voters' => [0, 2, 4],
            ],
            [
                'title' => 'Markdown support in descriptions',
                'description' => 'Being able to format feedback with headings, bold text, and code blocks would make longer suggestions much easier to read.',
                'status' => 'planned',
                'user' => 2,
                'voters' => [0, 1, 3],
            ],
            [
                'title' => 'Filter feedback by status',
                'description' => 'The dashboard gets busy as more feedback comes in. A simple filter to show only Planned or In Progress items would help a lot.',
                'status' => 'under_review',
                'user' => 3,
                'voters' => [0, 1],
            ],
            [
                'title' => 'Public API for integrations',
                'description' => 'We use Slack internally and it would be useful to post new feedback directly from a Slack command. A simple REST API would enable that.',
                'status' => 'under_review',
                'user' => 4,
                'voters' => [1],
            ],
            [
                'title' => 'Allow editing feedback after submission',
                'description' => 'Sometimes I spot a typo or want to add more context after submitting. Being able to edit within a short window would be helpful.',
                'status' => 'planned',
                'user' => 0,
                'voters' => [2, 3, 4],
            ],
            [
                'title' => 'Sort dashboard by most voted',
                'description' => 'Right now everything is sorted by newest. It would be nice to sort by vote count so the most popular ideas float to the top.',
                'status' => 'under_review',
                'user' => 2,
                'voters' => [0, 3],
            ],
        ];

        foreach ($ideas as $data) {
            $idea = Idea::forceCreate([
                'user_id' => $users[$data['user']]->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
                'votes' => count($data['voters']),
            ]);

            $voterIds = $users->only($data['voters'])->pluck('id');
            $idea->voters()->attach($voterIds);
        }
    }
}
