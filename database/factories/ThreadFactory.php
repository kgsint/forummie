<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(6, true),
            'user_id' => User::factory(),
            'topic_id' => rand(1, 3), // instead of Topic::factory, want to make it specific
            'description' => $this->faker->paragraph(rand(3, 6)),
        ];
    }
}
