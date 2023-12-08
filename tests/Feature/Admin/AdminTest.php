<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    // test Authenticate middleware
    public function test_guest_cannot_visit_admin_routes()
    {
        $response = $this->get('/admin/users');

        $response->assertRedirect('/login');
    }

    // test VerifyAdmin middleware
    public function test_default_user_cannot_visit_admin_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/users');

        $response->assertForbidden();
    }

    // test moderator cannot delete use and admin
    public function test_moderator_cannot_delete_default_user_and_admin()
    {
        $admin = User::factory()->create([
            'type' => User::ADMIN,
        ]);
        $moderator = User::factory()->create([
            'type' => User::MODERATOR,
        ]);
        $user = User::factory()->create([
            'type' => User::DEFAULT,
        ]);

        // delete $user
        $response = $this->actingAs($moderator)
                                ->delete(
                                    route('admin.users.destroy', [
                                        'user' => $user
                                    ]));

        $response->assertForbidden('admin.users.index');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
        ]);

        // delete $admin
        $response = $this->actingAs($moderator)
                                ->delete(
                                    route('admin.users.destroy', [
                                        'user' => $admin
                                    ]));

        $response->assertForbidden();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
        ]);
    }

    // test admin can delete user and moderator
    public function test_admin_can_delete_moderator_and_default_user()
    {
        $admin = User::factory()->create([
            'type' => User::ADMIN,
        ]);
        $moderator = User::factory()->create([
            'type' => User::MODERATOR,
        ]);
        $user = User::factory()->create([
            'type' => User::DEFAULT,
        ]);

        // delete moderator
        $response = $this->actingAs($admin)
                                ->delete(route(
                                    'admin.users.destroy', [
                                        'user' => $moderator
                                    ]));

        // assertions
        $response->assertRedirectToRoute('admin.users.index');
        $this->assertDatabaseMissing('users', [
            'id' => $moderator->id,
            'name' => $moderator->name,
            'username' => $moderator->username,
            'email' => $moderator->email,
        ]);

        // delete default user
        $response = $this->actingAs($admin)
                                ->delete(route(
                                    'admin.users.destroy', [
                                        'user' => $user
                                    ]));


        // assertions
        $response->assertRedirectToRoute('admin.users.index');
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
        ]);
    }
}
