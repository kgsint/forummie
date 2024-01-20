<?php

namespace Tests\Feature\Forum;

use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class ThreadNotificationTest extends TestCase
{
    public function test_it_notifies_to_thread_owner_when_other_user_reply_to_the_thread()
    {
        $user = $this->signIn();
        $thread = Thread::factory()->create(['user_id' => $user->id]);

        $this->actingAs($anotherUser = User::factory()->create())
                                                ->post(route('posts.store', $thread), ['body' => 'A reply']);

        $this->assertEquals(1, $user->notifications->count());

        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'data' => json_encode([
                'type' => 'thread_reply',
                'message' => "@{$anotherUser->username} answered your thread",
                'thread_title' => $thread->title,
                'url' => route('forum.show', ['thread' => $thread, 'post' => Post::find(1)->id])
            ])
        ]);
    }

    public function test_it_wont_notify_when_the_thread_owner_reply_to_their_own_thread()
    {
        $user = $this->signIn();
        $thread = Thread::factory()->create(['user_id' => $user->id]);

        $this->post(route('posts.store', $thread), ['body' => 'A reply']);

        $this->assertEquals(0, $user->notifications->count());
    }
}
