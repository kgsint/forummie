<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ForumTest extends TestCase
{
    use RefreshDatabase;

    // test for index page
    public function test_index_page_of_forum_is_displayed()
    {
        Thread::factory(1)->create([
            'title' => 'Title of the first thread',
            'body' => 'Body of the first thread',
        ]);
        Thread::factory(9)->create();

        $response = $this->get(route('forum.index'));

        $response->assertStatus(200);

        // inertia assertions
        $response->assertInertia(
            fn(Assert $page)
                            => $page
                                    ->url('/')
                                    ->component('Forum/Index')
                                    ->has('threads') // passing prop
                                    ->has('threads.data', 10) // thread's collection count
                                    ->has('threads.data.0', 9) // no of properties in single thread
                                    ->where('threads.data.0.title', 'Title of the first thread') // title of the first thread
                                    ->where('threads.data.0.body', 'Body of the first thread') // body of the first thread

        );
    }

    // test for show page
    public function test_show_page_of_forum_is_displayed()
    {
        $thread = Thread::factory()->create([
            'title' => 'Title of the thread',
            'body' => 'Body of the thread',
        ]);

        $response = $this->get(route('forum.show', $thread->slug));

        $response->assertStatus(200);

        // inertia test
        $response->assertInertia(
            fn(Assert $page) =>
                        $page->url("/threads/{$thread->slug}")
                            ->component('Forum/Show')
                            ->has('thread', 7) // passing prop
                            ->where('thread.title', 'Title of the thread') // title of the thread
                            ->where('thread.body', 'Body of the thread') // body of the thread
                            ->has('posts') // passing prop
        );
    }

    // test for auth middleware
    public function test_guests_cannot_create_a_thread()
    {
        $topic = Topic::factory()->create();

        $response = $this->post(route('forum.store', [
                                                        'title' => 'Title of the thread',
                                                        'body' => 'Body of the thread',
                                                        'topic_id' => $topic->id,
                                                    ])
                                                );

        // redirect to login page
        $response->assertRedirect('/login');

        // does not create row in database
        $this->assertDatabaseMissing('threads', [
            'title' => 'Title of the thread',
            'body' => 'Body of the thread',
            'topic_id' => $topic->id,
        ]);
    }

    // test for creating thread
    public function test_authenticated_user_can_create_a_thread()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create();

        $response = $this->actingAs($user)
                        ->post(route('forum.store', [
                                                        'title' => 'Title of the thread',
                                                        'body' => 'Body of the thread',
                                                        'topic_id' => $topic->id,
                                                    ])
                                                );
        // assesrt redirect response
        $response->assertStatus(302);

        $this->assertDatabaseHas('threads', [
            'title' => 'Title of the thread',
            'body' => 'Body of the thread',
            'topic_id' => $topic->id,
        ]);
    }

    // test validation for creating thread
    public function test_validation_for_creating_thread()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                                        ->post(route('forum.store'), [
                                            'title' => '',
                                            'body' => '',
                                            'topic_id' => '',
                                        ]);

        $response->assertSessionHasErrors(['title', 'body', 'topic_id']);
    }
}
