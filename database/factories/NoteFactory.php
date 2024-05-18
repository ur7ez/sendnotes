<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid,
            'user_id' => User::factory(),
            'title' => fake()->words(5, true),
            'body' => fake()->paragraph,
            'recipient' => fake()->email,
            'send_date' => fake()->dateTimeBetween('now', '+15 days')->format('Y-m-d'),
            'is_published' => true,
            'heart_count' => fake()->numberBetween(0, 20),
        ];
    }
}
