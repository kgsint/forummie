<?php

namespace Database\Seeders;

use App\Models\Thread;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Thread::factory(10)->create([
            'user_id' => rand(1, 3),
            'topic_id' => rand(1, 3),
        ]);
    }
}
