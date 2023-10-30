<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Topic::factory()->create([
            'name' => 'Laravel',
            'slug' => 'laravel'
        ]);

        Topic::factory()->create([
            'name' => 'PHP',
            'slug' => 'php',
        ]);

        Topic::factory()->create([
            'name' => 'DevOps',
            'slug' => 'devops',
        ]);
    }
}
