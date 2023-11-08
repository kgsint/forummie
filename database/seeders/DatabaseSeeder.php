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

        $this->call([
            ThreadSeeder::class,
            TopicSeeder::class,
        ]);
    }
}
