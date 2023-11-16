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
                                    ->has('threads.data.0', 11) // no of properties in single thread
                                    ->has('threads.data.0.title') // title of the first thread
                                    ->has('threads.data.0.body') // body of the first thread

        );
    }

    // markdown test for index route
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
                                        'threads.data.0.body',
                                        "<p>Body of the first thread.</p>\n")// <p> tag
                                    ->where(
                                        'threads.data.1.body',
                                        '<h1 id="body-of-the-first-thread">Body of the first thread.</h1>' . "\n" // h1 tag
                                    )
                                    ->where(
                                        'threads.data.2.body',
                                        "<p><strong>bold text</strong></p>\n" // bold tag
                                    )

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
                            ->has('thread', 10) // passing prop
                            ->has('thread.title') // title of the thread
                            ->has('thread.body') // body of the thread
                            ->has('posts') // passing prop
        );
    }

    // markdown test for show route
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

        // store request
        $response = $this->actingAs($user)
                        ->post(route('forum.store', [
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
        $user = User::factory()->create();

        // store request
        $response = $this->actingAs($user)
                                        ->post(route('forum.store'), [
                                            'title' => '',
                                            'body' => '',
                                            'topic_id' => '',
                                        ]);
        // assert errors
        $response->assertSessionHasErrors(['title', 'body', 'topic_id']);
    }

    // markdown test for store route
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
        $user = User::factory()->create();
        $topic = Topic::factory()->create();

        $thread = Thread::factory()->create([
            'user_id' => $user->id,
            'topic_id' => $topic->id,
        ]);

        $response = $this->actingAs($user)->patch(route('forum.update', $thread), [
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
        $user = User::factory()->create();

        $thread = Thread::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete(route('forum.destroy', $thread));

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
