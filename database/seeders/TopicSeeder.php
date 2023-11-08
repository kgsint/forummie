<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
