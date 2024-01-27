<?php

namespace Tests\Feature\Forum;

use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ThreadPostTest extends TestCase
{
    // posts and replies test
    public function test_posts_and_replies_of_the_thread_are_displayed()
    {
        $thread = Thread::factory()->create();

        $post = Post::factory()->create(['thread_id' => $thread->id]);
        Post::factory(2)->create(['thread_id' => $thread->id]);
        // replies of the $post
        $replyOne = Post::factory()->create(['thread_id' => $thread->id, 'parent_id' => $post->id]);
        $replyTwo = Post::factory()->create(['thread_id' => $thread->id, 'parent_id' => $post->id]);

        // in show page of forum
        $response = $this->get(route('forum.show', $thread->slug));

        $response->assertInertia(
            fn(Assert $page) => $page
                                    ->has('posts.data', 3)
                                    ->where('posts.data.0.replies', fn($replies) => $replies->count() === 2)
        );
    }

    // store test for guest
    public function test_guest_cannot_create_reply_post()
    {
        $thread = Thread::factory()->create();

        $response = $this->post(route('posts.store', ['thread' => $thread]), [
            'body' => 'This is reply post body',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('posts', [
            'body' => 'This is reply post body',
        ]);
    }

    // store test for authenticated user
    public function test_authenticated_user_can_create_reply_post()
    {
        $user = User::factory()->create();

        $thread = Thread::factory()->create();

        $response = $this->actingAs($user)
                                        ->post(route('posts.store', ['thread' => $thread]), [
            'body' => 'This is reply post'
        ]);

        // get the latest created post/reply
        $post = Post::latest('id')->first();

        $response->assertRedirect("/threads/{$thread->slug}?post={$post->id}");
        $this->assertDatabaseHas('posts', [
            'body' => 'This is reply post',
            'thread_id' => $thread->id,
        ]);
    }

    // validation for creating post
    public function test_it_validates_when_creating_the_reply_post()
    {
        $user = User::factory()->create();

        $thread = Thread::factory()->create();

        $response = $this->actingAs($user)
                                        ->post(
                                            route('posts.store', ['thread' => $thread]), ['body' => '']
                                        );

        $response->assertSessionHasErrors(['body' => 'The text body cannot be empty']);
    }

    // test jump to the currently create post
    public function test_it_jump_to_the_page_the_newly_created_post()
    {
        $thread = Thread::factory()->create();
        Post::factory(10)->create(['thread_id' => $thread->id]);

        $response = $this->actingAs(User::factory()->create())->post(
            route('posts.store', ['thread' => $thread]), [
                'body' => 'A new reply',
            ]
            );
        // get the currently created post
        $post = Post::latest('id')->first();

        // check response with query string of 'post=id' when created
        $response->assertRedirectToRoute('forum.show', ['thread' => $thread, 'post' => $post->id]);

        // making request to forum.show route with query param of '?post=id'
        $response = $this->get(route('forum.show', ['thread' => $thread, 'post' => $post->id]));

        // assertion of redirect back to the page of the created post (the post is 11th and assuming post per page is 10)
        $response->assertRedirect(
            route('forum.show', ['thread' => $thread, 'page' => 2, 'post_id' => $post->id])
        );
    }

    public function test_guest_cannot_update_a_post_reply()
    {
        $post = Post::factory()->create();

        $response = $this->patch(
            route('posts.update',
                    ['thread' => $post->thread, 'post' => $post]
                ), ['body' => 'A updated reply']);

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_update_their_post_reply()
    {
        $user = $this->signIn();

        $post = Post::factory()->create(['user_id' => $user->id]);
        $this->patch(
            route(
                'posts.update',
                ['thread' => $post->thread, 'post' => $post]
            ),
            $attributes = ['body' => 'A updated body']
        )
            ->assertRedirect(route('forum.show', ['thread' => $post->thread->slug, 'post' => $post->id]));

        $this->assertDatabaseHas('posts', $attributes);
    }

    public function test_authenticated_user_cannot_update_other_post_reply()
    {
        $user = $this->signIn();

        $post = Post::factory()->create(['user_id' => $user->id]);
        $this->actingAs(User::factory()->create())->patch(
            route(
                'posts.update',
                ['thread' => $post->thread, 'post' => $post]
            ),
            ['body' => 'A updated body']
        )
            ->assertForbidden();
    }

    public function test_guest_user_cannot_delete_a_post_reply()
    {
        $post = Post::factory()->create();

        $this->delete(
            route('posts.destroy', ['thread' => $post->thread, 'post' => $post])
        )
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_delete_their_reply_post()
    {
        $user = $this->signIn();

        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->delete(
                route('posts.destroy', ['thread' => $post->thread, 'post' => $post])
            )
                ->assertRedirect(route('forum.show', ['thread' => $post->thread]));

        $this->assertDatabaseMissing('posts', [
            'body' => $post->body,
        ]);
    }

    public function test_authenticated_user_cannot_delete_others_post_reply()
    {
        $user = $this->signIn();

        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs(User::factory()->create())->delete(
                route('posts.destroy', ['thread' => $post->thread, 'post' => $post])
            )
                ->assertForbidden();

        $this->assertDatabaseMissing('posts', [
            'post' => $post->body,
        ]);
    }

    public function test_admin_or_moderator_can_delete_can_delete_reply_post()
    {
        // admin
        $this->signIn(User::factory()->create(['type' => User::ADMIN]));
        $post = Post::factory()->create();

        $response = $this->delete(route('posts.destroy', ['thread' => $post->thread, 'post' => $post]));
        $response->assertRedirect(route('forum.show', ['thread' => $post->thread]));
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'body' => $post->body,
            'user_id' => $post->user_id,
        ]);

        // moderator
        $this->signIn(User::factory()->create(['type' => User::MODERATOR]));
        $post = Post::factory()->create();

        $response = $this->delete(route('posts.destroy', ['thread' => $post->thread, 'post' => $post]));
        $response->assertRedirect(route('forum.show', ['thread' => $post->thread]));
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'body' => $post->body,
            'user_id' => $post->user_id,
        ]);
    }
}
