<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class QueryFilterTest extends TestCase
{
    use RefreshDatabase;

    // no replies filter test
    public function test_it_can_filter_thread_with_no_replies()
    {
        // total of 3 threads
        $threadOne = Thread::factory()->create();
        $threadTwo = Thread::factory()->create();
        $threadThree = Thread::factory()->create();

        // replies for $threadTwo and $threadThreee
        Post::factory()->create(['thread_id' => $threadTwo->id]);
        Post::factory()->create(['thread_id' => $threadThree->id]);

        // filter response
        $response = $this->get(route('forum.index', ['filter[noreplies]' => '1']));
        $response->assertSuccessful();

        // end point assertions
        $response->assertInertia(
            fn(Assert $page) => $page->has('threads.data', 1)   // no of thereads displayed
                                        ->where('threads.data.0.title', $threadOne->title)
                                        ->where('threads.data.0.body', "<p>{$threadOne->body}</p>\n") // markdown to html
                                        ->where('threads.data.0.body_markdown', $threadOne->body) // raw body
        );
    }

    // resolved filter test
    public function test_it_can_filter_thread_with_solution()
    {
        $threadOne = Thread::factory()->create();
        $threadTwo = Thread::factory()->create();
        $threadThree = Thread::factory()->create();

        $solutionPost = Post::factory()->create(['thread_id' => $threadOne->id]);
        Post::factory()->create(['thread_id' => $threadTwo->id]);
        Post::factory()->create(['thread_id' => $threadThree->id]);

        // mark as best answer
        $threadOne->solution_post_id = $solutionPost->id;
        $threadOne->save();

        // filter response
        $response = $this->get(route('forum.index', ['filter[resolved]' => '1']));
        $response->assertSuccessful();

        // end point test
        $response->assertInertia(
            fn(Assert $page)
            => $page->has('threads.data', 1)    // no of thereads displayed
                    ->where('threads.data.0.title', $threadOne->title)
                    ->where('threads.data.0.body', "<p>{$threadOne->body}</p>\n") // markdown to html
                    ->where('threads.data.0.body_markdown', $threadOne->body) // raw body
        );
    }

    // unresolved filter test
    public function test_it_can_filter_thread_without_solution()
    {
        $threadOne = Thread::factory()->create();
        $threadTwo = Thread::factory()->create();
        $threadThree = Thread::factory()->create();

        $solutionPost = Post::factory()->create(['thread_id' => $threadOne->id]);
        Post::factory()->create(['thread_id' => $threadTwo->id]);
        Post::factory()->create(['thread_id' => $threadThree->id]);

        // mark as best answer
        $threadOne->solution_post_id = $solutionPost->id;
        $threadOne->save();

        // filter response
        $response = $this->get(route('forum.index', ['filter[unresolved]' => '1']));
        $response->assertSuccessful();

        // end point test
        $response->assertInertia(
            fn(Assert $page)
            => $page->has('threads.data', 2) // no of thereads displayed
                    ->where('threads.data.0.title', $threadTwo->title)
                    ->where('threads.data.0.body', "<p>{$threadTwo->body}</p>\n") // markdown to html
                    ->where('threads.data.0.body_markdown', $threadTwo->body) // raw body
        );
    }

    // test for my threads query filter
    public function test_it_can_filter_my_threads()
    {
        $me = User::factory()->create();
        $userOne = User::factory()->create();
        $userTwo = User::factory()->create();

        // create 2 thread by $me
        $myThreadOne = Thread::factory()->create(['user_id' => $me->id]);
        $myThreadTwo = Thread::factory()->create(['user_id' => $me->id]);

        Thread::factory(2)->create(['user_id' => $userOne->id]);
        Thread::factory(3)->create(['user_id' => $userTwo->id]);

        $initialResponse = $this->get(route('forum.index'));
        $initialResponse->assertSuccessful();
        // initial page load
        $initialResponse->assertInertia(
            fn(Assert $page) => $page->has('threads.data', 7) // initial page load with total of 7 threads
        );

        // should not work when filter as a guest
        $guestResponse = $this->get(route('forum.index', ['filter[mine]' => '1']));
        $guestResponse->assertInertia(fn(Assert $page) => $page->has('threads.data', 7)); //threads remain the same

        // should work as authenticated user
        $guestResponse = $this->actingAs($me)->get(route('forum.index', ['filter[mine]' => '1']));
        $guestResponse->assertInertia(
            fn(Assert $page) =>
                        $page->has('threads.data', 2) // total of 2 threads
                            ->where('threads.data.0.title', $myThreadOne->title)
                            ->where('threads.data.0.body', "<p>{$myThreadOne->body}</p>\n") // markdown to html
                            ->where('threads.data.0.body_markdown', $myThreadOne->body) // raw body
                    );
    }
}
