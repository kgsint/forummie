<?php

namespace Database\Factories;

use App\Models\Topic;
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
            'user_id' => User::factory(),  // instead of User::factory(), want to make it specific
            'topic_id' => Topic::factory(), // instead of Topic::factory(), want to make it specific
            'body' => $this->faker->paragraph(rand(3, 6)),
        ];
    }
}
