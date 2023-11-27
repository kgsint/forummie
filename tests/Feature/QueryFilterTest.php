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

    public function test_it_can_filter_thread_with_no_replies()
    {
        // total of 3 threads
        $threadOne = Thread::factory()->create();
        $threadTwo = Thread::factory()->create();
        $threadThree = Thread::factory()->create();

        // replies for $threadTwo and $threadThreee
        Post::factory()->create(['thread_id' => $threadTwo->id]);
        Post::factory()->create(['thread_id' => $threadThree->id]);

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
}
