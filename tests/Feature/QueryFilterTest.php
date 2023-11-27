<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class QueryFilterTest extends TestCase
{
    use RefreshDatabase;

    // filter no replies test
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
            fn(Assert $page) => $page->has('threads.data', 1)
                                        ->where('threads.data.0.title', $threadOne->title)
                                        ->where('threads.data.0.body', "<p>{$threadOne->body}</p>\n") // markdown to html
                                        ->where('threads.data.0.body_markdown', $threadOne->body) // raw body
        );
    }

    // filter resolved thread test
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
            => $page->has('threads.data', 1)
                    ->where('threads.data.0.title', $threadOne->title)
                    ->where('threads.data.0.body', "<p>{$threadOne->body}</p>\n") // markdown to html
                    ->where('threads.data.0.body_markdown', $threadOne->body) // raw body
        );
    }
}
