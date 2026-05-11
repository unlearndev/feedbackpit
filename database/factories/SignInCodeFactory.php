<?php

namespace Database\Factories;

use App\Models\SignInCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SignInCode>
 */
class SignInCodeFactory extends Factory
{
    protected $model = SignInCode::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => UserFactory::new(),
            'code' => (string) fake()->numberBetween(100000, 999999),
            'expires_at' => now()->addMinutes(15),
        ];
    }
}
