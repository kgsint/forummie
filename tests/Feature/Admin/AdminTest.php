<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Tests\TestCase;

class AdminTest extends TestCase
{
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

    public function test_admin_or_moderator_can_create_user()
    {
        $admin = User::factory()->create(['type' => User::ADMIN]);
        $moderator = User::factory()->create(['type' => User::MODERATOR]);

        // admin
        $response = $this->actingAs($admin)->post(route('admin.users.store', $attributes = [
            'name' => 'Test User',
            'email' => 'testuser@gmail.com',
            'username' => 'test_user',
            'type' => User::ADMIN,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]));
        $response->assertRedirectToRoute('admin.users.index');
        $this->assertDatabaseHas('users', [
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'username' => $attributes['username'],
            'type' => $attributes['type'],
        ]);

        // moderator
        $response = $this->actingAs($moderator)->post(route('admin.users.store', $attributes = [
            'name' => 'Test User One',
            'email' => 'testuser1@gmail.com',
            'username' => 'test_user1',
            'type' => User::MODERATOR,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]));

        $response->assertRedirectToRoute('admin.users.index');
        $this->assertDatabaseHas('users', [
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'username' => $attributes['username'],
            'type' => $attributes['type'],
        ]);
    }

    public function test_moderator_cannot_create_admin_account()
    {
        $moderator = User::factory()->create(['type' => User::MODERATOR]);

        $response = $this->actingAs($moderator)->post(route('admin.users.store', $attributes = [
            'name' => 'Test User One',
            'email' => 'testuser1@gmail.com',
            'username' => 'test_user1',
            'type' => User::ADMIN,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]));

        $response->assertForbidden();
        $this->assertDatabaseMissing('users', [
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'username' => $attributes['username'],
            'type' => $attributes['type'],
        ]);
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
