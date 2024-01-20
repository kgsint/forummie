<?php

namespace Tests\Feature\Forum;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/account-info');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put('/account-info', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'username' => 'test_username',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/account-info');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_profile_photo_can_be_uploaded()
    {
        Storage::fake();

        $user = User::factory()->create();

        $attributes = [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
        ];

        $response = $this->actingAs($user)
                                            ->put(route('profile.update'), array_merge(
                                                $attributes,
                                                ['photo' => UploadedFile::fake()->image('profile-photo.jpg')]
                                            ));

        $response->assertStatus(302);
        $this->assertTrue(Storage::exists($user->profile_avatar_path));
        $this->assertDatabaseHas('users', array_merge(
            $attributes,
            ['profile_avatar_path' => $user->profile_avatar_path]
        ));
    }

    public function test_profile_avatar_mimes_type_validation()
    {
        $user = User::factory()->create();

        $attributes = [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
        ];

        $response = $this->actingAs($user)
                                            ->put(route('profile.update'), array_merge(
                                                $attributes,
                                                ['photo' => UploadedFile::fake()->create('my-table.csv')]
                                            ));

        $response->assertInvalid(['photo' => 'Photo must be type of png, jpg or jpeg']);

        $response = $this->actingAs($user)
                                            ->put(route('profile.update'), array_merge(
                                                $attributes,
                                                ['photo' => UploadedFile::fake()->create('my-photo.png')]
                                            ));

        $response->assertValid(['photo']);
    }

    public function test_profile_avatar_max_size_validation()
    {
        $user = User::factory()->create();

        $attributes = [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
        ];

        $response = $this->actingAs($user)
                                            ->put(route('profile.update'), array_merge(
                                                $attributes,
                                                ['photo' => UploadedFile::fake()->create('mine.png', 2049)]
                                            ));

        $response->assertInvalid(['photo' => 'Photo must not be greater than 2MB']);

        $response = $this->actingAs($user)
                                            ->put(route('profile.update'), array_merge(
                                                $attributes,
                                                ['photo' => UploadedFile::fake()->create('mine.png', 1000)]
                                            ));

        $response->assertValid(['photo']);
    }

    public function test_update_profile_pic_remove_old_one()
    {
        $user = User::factory()->create();

        $attributes = [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
        ];

        $response = $this->actingAs($user)
                                            ->put(route('profile.update'), array_merge(
                                                $attributes,
                                                ['photo' => UploadedFile::fake()->create('photo-1.png', 1000)]
                                            ));
        $response->assertStatus(302);
        $this->assertTrue(Storage::exists($prevPicPath = $user->profile_avatar_path));

        // upload new profile pic
        $response = $this->actingAs($user)
                                    ->put(route('profile.update'), array_merge(
                                        $attributes,
                                        ['photo' => UploadedFile::fake()->create('photo-2.png', 1000)]
                                    ));
        // delete previous pic assertion
        $this->assertFalse(Storage::exists($prevPicPath));
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put('/account-info', [
                'name' => 'Test User',
                'email' => $user->email,
                'username' => 'test_username'
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/account-info');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/account-info', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/account-info')
            ->delete('/account-info', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect('/account-info');

        $this->assertNotNull($user->fresh());
    }
}
