<?php

namespace Database\Factories;

use App\Enums\IdeaStatus;
use App\Models\IdeaStatusUpdate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IdeaStatusUpdate>
 */
class IdeaStatusUpdateFactory extends Factory
{
    protected $model = IdeaStatusUpdate::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idea_id' => IdeaFactory::new(),
            'user_id' => UserFactory::new()->teamMember(),
            'from_status' => IdeaStatus::UnderReview,
            'to_status' => IdeaStatus::Planned,
            'message' => null,
        ];
    }
}
