<?php

namespace Tests\Feature\Forum;

use App\Models\Thread;
use App\Models\Topic;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ThreadTest extends TestCase
{
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
                                    ->has('threads.data.0', 12) // no of properties in thread resource
                                    ->has('threads.data.0.title') // title of the first thread
                                    ->has('threads.data.0.body') // body of the first thread

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
                            ->has('thread', 11) // no of properties in thread resource for show page of the therad/forum
                            ->has('thread.title') // title of the thread
                            ->has('thread.body') // body of the thread
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
        $user = $this->signIn();
        $topic = Topic::factory()->create();

        // store request
        $response = $this->post(route('forum.store', [
                                                        'title' => 'Title of the thread',
                                                        'body' => 'Body of the thread',
                                                        'topic_id' => $topic->id,
                                                    ])
                                                );
        // assert redirect response
        $response->assertStatus(302);

        //assert db
        $this->assertDatabaseHas('threads', [
            'title' => 'Title of the thread',
            'body' => 'Body of the thread',
            'topic_id' => $topic->id,
        ]);
    }

    // test validation for creating thread
    public function test_validation_for_creating_thread()
    {
        $user = $this->signIn();

        // store request
        $response = $this->post(route('forum.store'), [
                                            'title' => null,
                                            'body' => null,
                                            'topic_id' => null,
                                        ]);
        // assert errors
        $response->assertInvalid(['title', 'body', 'topic_id']);
    }

    // guest update test
    public function test_guest_cannot_update_thread()
    {
        $thread = Thread::factory()->create();

        $response = $this->patch(route('forum.update', $thread), [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
        ]);

        // asssertions
        $response->assertRedirectToRoute('login');
        $this->assertDatabaseMissing('threads', [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
        ]);
    }

    // update test for auth user
    public function test_authenticated_user_can_update_thread()
    {
        $user = $this->signIn();
        $topic = Topic::factory()->create();

        $thread = Thread::factory()->create([
            'user_id' => $user->id,
            'topic_id' => $topic->id,
        ]);

        $response = $this->patch(route('forum.update', $thread), [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
            'topic_id' => $topic->id,
        ]);

        // assertions
        $response->assertRedirectToRoute('forum.show', $thread);
        $this->assertDatabaseHas('threads', [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
            'topic_id' => $topic->id,
        ]);
    }

    // authorize update test
    public function test_authenticated_user_cannot_update_others_thread()
    {
        $userOne = User::factory()->create();
        $userTwo = User::factory()->create();
        $topic = Topic::factory()->create();

        $thread = Thread::factory()->create([
            'user_id' => $userOne->id,
            'topic_id' => $topic->id,
        ]);

        // making request as another user
        $response = $this->actingAs($userTwo)
                                        ->patch(route('forum.update', $thread), [
                                            'title' => 'Update Title',
                                            'body' => 'Update Body',
                                            'topic_id' => $topic->id,
                                        ]);
        // assert status
        $response->assertStatus(403);
        // make sure to not update data in database level
        $this->assertDatabaseMissing('threads', [
            'title' => 'Update Title',
            'body' => 'Update Body',
            'topic_id' => $topic->id,
        ]);
    }

    // guest delete test
    public function test_guest_cannot_delete_thread()
    {
        $thread = Thread::factory()->create();

        $response = $this->delete(route('forum.destroy', $thread));

        $response->assertRedirect('/login');
    }

    // delete test
    public function test_authenticated_user_can_delete_their_thread()
    {
        $user = $this->signIn();

        $thread = Thread::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->delete(route('forum.destroy', $thread));

        $response->assertRedirectToRoute('forum.index');

        // check in db
        $this->assertDatabaseMissing('threads', [
            'title' => $thread->title,
            'body' => $thread->body,
            'user_id' => $user->id,
        ]);
    }

    // authorize delete thread
    public function test_authenticated_user_cannot_delete_others_thread()
    {
        $userOne = User::factory()->create();
        $userTwo = User::factory()->create();

        $thread = Thread::factory()->create([
            'user_id' => $userOne->id,
        ]);

        // making delete request as $userTwo
        $response = $this->actingAs($userTwo)
                                        ->delete(route('forum.destroy', $thread));


        $response->assertStatus(403);
        // check in db
        $this->assertDatabaseHas('threads', [
            'title' => $thread->title,
            'body' => $thread->body,
            'user_id' => $userOne->id,
        ]);
    }
}

