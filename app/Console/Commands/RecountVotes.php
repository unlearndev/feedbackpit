<?php

namespace App\Console\Commands;

use App\Models\Idea;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class RecountVotes extends Command
{
    protected $signature = 'votes:recount';

    protected $description = 'Recalculate the cached vote count on every idea from its voters';

    public function handle(): int
    {
        Idea::query()->chunkById(100, function (Collection $ideas) {
            foreach ($ideas as $idea) {
                $idea->votes = $idea->voters()
                    ->where('users.id', '!=', $idea->user_id)
                    ->count();

                $idea->saveQuietly();
            }
        });

        $this->info('Vote counts recalculated.');

        return self::SUCCESS;
    }
}
