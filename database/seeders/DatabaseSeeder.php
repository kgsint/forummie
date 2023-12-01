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
        User::factory()->create([
            'name' => 'kgsint',
            'email' => 'kgsint@mail.co.uk',
            'username' => 'kgsint',
            'type' => User::ADMIN,
        ]);

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'username' => 'johndoe',
            'type' => User::MODERATOR,
        ]);

        User::factory()->create([
            'name' => 'Sussy',
            'email' => 'sussy@gmail.com',
            'username' => 'sussy',
            'type' => User::ADMIN,
        ]);

        User::factory(10)->create();

        $this->call([
            TopicSeeder::class,
            ThreadSeeder::class,
        ]);
    }
}
