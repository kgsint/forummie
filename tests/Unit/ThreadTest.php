<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_user()
    {
        $user = User::factory()->create();

        $thread = Thread::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $thread->user);
    }

    public function test_it_has_replies_or_post()
    {
        $user = User::factory()->create();

        $thread = Thread::factory()->create(['user_id' => $user->id]);

        Post::factory(10)->create([
            'thread_id' => $thread->id,
        ]);

        $this->assertInstanceOf(Collection::class, $thread->posts);
        $this->assertCount(10, $thread->posts);
    }

    public function test_it_has_latest_post()
    {
        $user = User::factory()->create();

        $thread = Thread::factory()->create(['user_id' => $user->id]);

        Post::factory(10)->create([
            'thread_id' => $thread->id,
        ]);
        $latestPost = Post::factory()->create([
            'thread_id' => $thread->id,
        ]);

        $this->assertInstanceOf(Post::class, $thread->latestPost);
        $this->assertEquals($latestPost->id, $thread->latestPost->id);
    }

    public function test_it_has_solution()
    {
        $user = User::factory()->create();

        $thread = Thread::factory()->create(['user_id' => $user->id]);

        $post = Post::factory()->create([
            'thread_id' => $thread->id,
        ]);
        Post::factory()->create(['thread_id' => $thread->id]);

        $thread->solution_post_id = $post->id;
        $thread->save();

        $this->assertInstanceOf(Post::class, $thread->solution);
        $this->assertSame($post->id, $thread->solution->id);
    }

    public function test_it_has_mentioned_users_list()
    {
        $userOne = User::factory()->create([
            'name' => 'User One',
            'username' => 'userone'
        ]);
        $userTwo = User::factory()->create([
            'name' => 'User Two',
            'username' => 'usertwo'
        ]);

        $thread = Thread::factory()->create([
            'body' => 'Hey @userone @usertwo'
        ]);

        $this->assertInstanceOf(Collection::class, $thread->mentions);
        $this->assertCount(2, $thread->mentions);
    }
}
