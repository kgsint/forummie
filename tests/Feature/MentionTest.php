<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Thread;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MentionTest extends TestCase
{
    use RefreshDatabase;

    // test saved mentioned users records in post_metion pivot table
    public function test_it_recorded_the_mentioned_user_when_creating_reply_post()
    {
        $currentUser = User::factory()->create();

        $userOne = User::factory()->create([
            'name' => 'user one',
            'username' => 'user_one',
        ]);

        $userTwo = User::factory()->create([
            'name' => 'user two',
            'username' => 'user_two',
        ]);

        $thread = Thread::factory()->create();

        $this->actingAs($currentUser)->post(route('posts.store', ['thread' => $thread]), [
            'body' => 'Hello @user_one @user_two',
        ]);

        // db assertions
        $this->assertDatabaseHas('post_mention', [
            'user_id' => $userOne->id,
            'post_id' => Post::first()->id,
        ]);
        $this->assertDatabaseHas('post_mention', [
            'user_id' => $userTwo->id,
            'post_id' => Post::first()->id,
        ]);
    }

    // test saved mentioned users records in thread_metion pivot table
    public function test_it_recorded_the_mentioned_user_when_creating_a_thread()
    {
        $currentUser = User::factory()->create();

        $userOne = User::factory()->create([
            'name' => 'user one',
            'username' => 'user_one',
        ]);

        $userTwo = User::factory()->create([
            'name' => 'user two',
            'username' => 'user_two',
        ]);

        $topic = Topic::factory()->create(['name' => 'Laravel']);

        $this->actingAs($currentUser)->post(route('forum.store'), [
            'title' => 'Thread Title',
            'body' => 'Hello, @user_one @user_two',
            'topic_id' => $topic->id
        ]);

        // assertions
        $this->assertDatabaseHas('thread_mention', [
            'user_id' => $userOne->id,
            'thread_id' => Thread::first()->id,
        ]);
        $this->assertDatabaseHas('thread_mention', [
            'user_id' => $userTwo->id,
            'thread_id' => Thread::first()->id,
        ]);
    }
}
