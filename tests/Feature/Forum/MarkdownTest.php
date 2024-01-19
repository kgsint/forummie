<?php

namespace Tests\Feature\Forum;

use Tests\TestCase;
use App\Models\User;
use App\Models\Topic;
use App\Models\Thread;
use Inertia\Testing\AssertableInertia as Assert;

class MarkdownTest extends TestCase
{
    // route('markdown.preview') test
    public function test_making_request_to_markdown_preview_route_should_return_html()
    {
        $response = $this->actingAs(User::factory()->create())->post(route('markdown.preview', ['body' => 'Body of the post or thread']));

        $response->assertSuccessful();
        $response->assertJson(['markdown_html' => "<p>Body of the post or thread</p>\n"]);
    }

    // markdown test for index route of forum
    public function test_thread_body_generate_markdown_to_html_in_forum_index_page()
    {
        Thread::factory()->create([
            'title' => 'Title of the first thread',
            'body' => "Body of the first thread.",
        ]);

        Thread::factory()->create([
            'title' => 'Title of the second thread',
            'body' => "# Body of the first thread.",
        ]);

        Thread::factory()->create([
            'title' => 'Title of the third thread',
            'body' => "**bold text**",
        ]);

        $response = $this->get(route('forum.index'));

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page)
                            => $page
                                    ->url('/')
                                    ->component('Forum/Index')
                                    ->has('threads') // passing prop
                                    ->where(
                                        'threads.data.2.body',
                                        "<p>Body of the first thread.</p>\n")// <p> tag
                                    ->where(
                                        'threads.data.1.body',
                                        '<h1 id="body-of-the-first-thread">Body of the first thread.</h1>' . "\n" // h1 tag
                                    )
                                    ->where(
                                        'threads.data.0.body',
                                        "<p><strong>bold text</strong></p>\n" // bold tag
                                    )

        );
    }

    // markdown test for show route of thread or forum
    public function test_thread_body_generate_markdown_to_html_in_forum_show_page()
    {
        $thread = Thread::factory()->create([
            'title' => 'Title of the thread',
            'body' => " # Primary Heading.\nBody of the thread.\n```php <?php echo \"thread\" ?> ```",
        ]);


        $response = $this->get(route('forum.show', $thread->slug));

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page)
                            => $page
                                    ->component('Forum/Show')
                                    ->has('thread') // passing prop
                                    ->where(
                                        'thread.body',
                                        "<h1 id=\"primary-heading\">Primary Heading.</h1>\n<p>Body of the thread.\n<code>php &lt;?php echo &quot;thread&quot; ?&gt; </code></p>\n")// markdown to html

        );
    }

    // markdown test for store route of thread or forum
    public function test_it_store_markdown_as_plain_text_in_database_and_generate_to_client_as_html()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create();

        $response = $this->actingAs($user)
                        ->post(route('forum.store', [
                                                        'title' => 'Title of the thread',
                                                        'body' => '# Body of the thread',
                                                        'topic_id' => $topic->id,
                                                    ])
                                                );

        // store in db as plain text
        $this->assertDatabaseHas('threads', [
            'title' => 'Title of the thread',
            'body' => '# Body of the thread',
            'topic_id' => $topic->id,
        ]);

        // visit to index route
        $response = $this->get(route('forum.index'));
        // render as html in forum/index page
        $response->assertInertia(
            fn(Assert $page) =>
                                $page
                                    ->has('threads')
                                    ->where('threads.data.0.body', "<h1 id=\"body-of-the-thread\">Body of the thread</h1>\n")
        );

        $thread = Thread::latest()->first();

        // visit to show route
        $response = $this->get(route('forum.show', $thread->slug));
        // render as html in forum/show page
        $response->assertInertia(
            fn(Assert $page) =>
                                $page
                                    ->has('thread')
                                    ->where('thread.body', "<h1 id=\"body-of-the-thread\">Body of the thread</h1>\n")
        );
    }

    // markdown test for creating post
    public function test_it_store_markdown_in_database_and_display_html_to_client()
    {
        $user = User::factory()->create();

        $thread = Thread::factory()->create();

        // create post
        $this->actingAs($user)->post(
            route('posts.store', ['thread' => $thread]
        ), [
            'body' => '**body** of the post',
        ]);

        // store as raw markdown
        $this->assertDatabaseHas('posts', [
            'body' => '**body** of the post'
        ]);

        $response = $this->get(route('forum.show', $thread));

        // render as html in client
        $response->assertInertia(
            fn(Assert $page) => $page->where('posts.data.0.body', "<p><strong>body</strong> of the post</p>\n")
        );
    }
}
