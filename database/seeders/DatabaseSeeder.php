<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Thread;
use App\Models\Topic;
use App\Models\User;
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

        User::factory()->create([
            'name' => 'kgsint',
            'email' => 'kgsint@mail.co.uk',
            'username' => 'kgsint'
        ]);

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'username' => 'johndoe'
        ]);

        User::factory()->create([
            'name' => 'Sussy',
            'email' => 'sussy@gmail.com',
            'username' => 'sussy'
        ]);

        Thread::factory(10)->create();
    }
}
