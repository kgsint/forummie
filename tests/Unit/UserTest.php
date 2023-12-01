<?php

namespace Tests\Unit;

use App\Models\User;
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
}
