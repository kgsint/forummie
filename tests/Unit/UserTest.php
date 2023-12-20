<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_admin()
    {
        $user = User::factory()->create([
            'type' => User::ADMIN,
        ]);

        $this->assertTrue($user->isAdmin());
    }

    public function test_user_is_moderator()
    {
        $user = User::factory()->create([
            'type' => User::MODERATOR,
        ]);

        $this->assertTrue($user->isModerator());
    }

    public function test_it_default_user()
    {
        $user = User::factory()->create();

        $this->assertSame(User::DEFAULT, $user->type);
    }

    public function test_user_has_threads()
    {
        $user = User::factory()->create();
        Thread::factory(3)->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Collection::class, $user->threads);
        $this->assertCount(3, $user->threads);
    }

    public function test_user_has_posts_or_replies()
    {
        $user = User::factory()->create();
        Post::factory(2)->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Collection::class, $user->posts);
        $this->assertCount(2, $user->posts);
    }

    public function test_user_can_be_banned()
    {
        $user = User::factory()->create();

        $this->assertFalse($user->isBanned());

        $user->ban('spamming');

        $this->assertTrue($user->isBanned());
    }

    public function test_user_can_be_unban()
    {
        $user = User::factory()->create();

        $user->ban('spamming');
        $this->assertTrue($user->isBanned());

        $user->unban();
        $this->assertFalse($user->isBanned());
    }

    public function test_user_have_default_avatar()
    {
        $user = User::factory()->create();

        $this->assertTrue(
            str_contains($user->getAvatar(), 'https://gravatar.com/avatar')
        );
    }
}
