<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
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

        $this->call([
            TopicSeeder::class,
        ]);

        $users = User::factory(30)->create();
        $threads = Thread::factory(50)->recycle($users)->recycle(Topic::all())->create();
        $posts = Post::factory(100)->recycle($users)->recycle($threads)->create();


    }
}
