<?php

namespace Tests\Feature\Forum;

use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class ThreadNotifyTest extends TestCase
{
    public function test_it_notifies_to_thread_owner_when_someone_reply_to_the_thread()
    {
        $this->actingAs($user = User::factory()->create());

        $thread = Thread::factory()->create(['user_id' => $user->id]);

        $this->actingAs(User::factory()->create())
                                                ->post(route('posts.store', ['thread' => $thread]), ['body' => 'Some Reply']);

        $this->assertEquals(1, $user->notifications->count());
    }

    public function test_it_does_not_notify_when_thread_owner_reply_to_their_thread()
    {
        $this->actingAs($user = User::factory()->create());

        $thread = Thread::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
                                ->post(
                                    route('posts.store', ['thread' => $thread]),
                                    ['body' => 'Replying to my own thread']
                                );

        $this->assertEquals(0, $user->notifications->count());
    }

    public function test_it_wont_notify_when_the_reply_is_the_nested_reply()
    {
        $user = User::factory()->create();

        $thread = Thread::factory()->create(['user_id' => $user->id]);
        // parent reply
        $parentPost = Post::factory()->create();

        // another reply
        $this->actingAs(User::factory()->create())
                                            ->post(
                                                route('posts.store', ['thread' => $thread]),
                                                [
                                                    'body' => 'Some Reply',
                                                    'parent_id' => $parentPost->id,
                                                ]);

        $this->assertEquals(0, $user->notifications->count());
    }
}
