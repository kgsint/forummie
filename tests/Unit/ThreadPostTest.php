<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_user()
    {
        $user = User::factory()->create();
        Post::factory(2)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Collection::class, $user->posts);
        $this->assertCount(2, $user->posts);
    }

    public function test_it_belongs_to_thread()
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create(['user_id' => $user->id]);
        Post::factory(5)->create(['thread_id' => $thread->id]);

        $this->assertInstanceOf(Collection::class, $thread->posts);
        $this->assertCount(5, $thread->posts);
    }

    public function test_it_has_nested_replies()
    {
        $post = Post::factory()->create();
        Post::factory(2)->create(['parent_id' => $post->id]);

        $this->assertInstanceOf(Collection::class, $post->replies);
        $this->assertCount(2, $post->replies);
    }

    public function test_it_belongs_to_parent_post()
    {
        $parent = Post::factory()->create();
        $post = Post::factory()->create(['parent_id' => $parent->id]);

        $this->assertInstanceOf(Post::class, $post->parent);
    }

    public function test_it_has_mentioned_users()
    {
        User::factory()->create(['username' => 'userone']);
        User::factory()->create(['username' => 'another_user']);

        $post = Post::factory()->create(['body' => 'Hello, @userone @another_user']);

        $this->assertInstanceOf(Collection::class, $post->mentions);
        $this->assertCount(2, $post->mentions);
    }
}
