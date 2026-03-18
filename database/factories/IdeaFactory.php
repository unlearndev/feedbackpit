<?php

namespace Database\Factories;

use App\Enums\IdeaStatus;
use App\Models\Idea;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Idea>
 */
class IdeaFactory extends Factory
{
    protected $model = Idea::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => UserFactory::new(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => IdeaStatus::UnderReview,
            'votes' => 0,
        ];
    }
}
