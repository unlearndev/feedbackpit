<?php

namespace Database\Seeders;

use App\Models\Comment;
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
            ['name' => 'Sarah Chen', 'email' => 'sarah@example.com', 'is_team_member' => true],
            ['name' => 'Marcus Johnson', 'email' => 'marcus@example.com', 'is_team_member' => true],
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
                'description' => 'I use the app late at night and the bright white interface is tough on the eyes. A dark mode toggle would make a big difference.',
                'status' => 'completed',
                'user' => 2,
                'voters' => [3, 4],
            ],
            [
                'title' => 'Email notifications for order updates',
                'description' => 'I want to get an email when my order ships or when there is a delay. Right now I have to keep checking the app manually.',
                'status' => 'in_progress',
                'user' => 3,
                'voters' => [2, 4],
            ],
            [
                'title' => 'Ability to save items to a wishlist',
                'description' => 'Sometimes I find something I like but I am not ready to buy yet. A wishlist feature would let me save items and come back to them later.',
                'status' => 'planned',
                'user' => 2,
                'voters' => [3, 4],
            ],
            [
                'title' => 'Better search with filters',
                'description' => 'The search works but I would love to filter results by price range, rating, and category. It would save a lot of scrolling.',
                'status' => 'under_review',
                'user' => 3,
                'voters' => [2, 4],
            ],
            [
                'title' => 'Multi-language support',
                'description' => 'I share the app with family members who prefer Spanish. It would be great if the interface could be switched between languages.',
                'status' => 'under_review',
                'user' => 4,
                'voters' => [2, 3],
            ],
            [
                'title' => 'Allow editing reviews after posting',
                'description' => 'I sometimes notice a typo or want to update my review after trying the product longer. Being able to edit within a short window would be really helpful.',
                'status' => 'planned',
                'user' => 4,
                'voters' => [2, 3],
            ],
            [
                'title' => 'Show estimated delivery date on product page',
                'description' => 'Before I buy I want to know roughly when it will arrive. Showing an estimated delivery date on the product page would help me decide.',
                'status' => 'under_review',
                'user' => 2,
                'voters' => [3, 4],
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

        // Sample comments on "Dark mode support"
        $darkMode = Idea::where('title', 'Dark mode support')->first();

        $this->createComment($darkMode, $users[3], 'Yes please! I work night shifts and this would be a game changer.');
        $this->createComment($darkMode, $users[0], 'Great news — dark mode shipped last week! Let us know if you run into any issues.');
        $this->createComment($darkMode, $users[4], 'Loving it so far. The contrast is easy on the eyes.');

        // Sample internal notes
        $emailNotifications = Idea::where('title', 'Email notifications for order updates')->first();

        $this->createNote($emailNotifications, $users[0], 'We should scope this to transactional emails only for v1.');
        $this->createNote($darkMode, $users[1], 'Confirmed with design — no issues in the latest QA pass.');
    }

    private function createComment(Idea $idea, User $user, string $body): void
    {
        $comment = new Comment(['body' => $body]);
        $comment->user()->associate($user);
        $comment->idea()->associate($idea);
        $comment->save();
    }

    private function createNote(Idea $idea, User $user, string $body): void
    {
        $comment = new Comment(['body' => $body, 'is_internal' => true]);
        $comment->user()->associate($user);
        $comment->idea()->associate($idea);
        $comment->save();
    }
}
