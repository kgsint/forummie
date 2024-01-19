<?php

namespace Tests\Feature\Admin;

use App\Models\Topic;
use App\Models\User;
use Tests\TestCase;

class TopicTest extends TestCase
{
    // view
    public function test_a_list_of_topics_can_be_viewed_by_only_admin_or_moderator()
    {
        $admin = User::factory()->create(['type' => User::ADMIN]);
        $moderator = User::factory()->create(['type' => User::MODERATOR]);
        $user = User::factory()->create();

        $this->actingAs($admin)
                ->get(route('admin.topics.index'))
                ->assertSuccessful();

        $this->actingAs($moderator)
                ->get(route('admin.topics.index'))
                ->assertSuccessful();

        $this->actingAs($user)
                ->get(route('admin.topics.index'))
                ->assertForbidden();
    }

    public function test_only_admin_or_moderator_can_create_topic()
    {
        $admin = User::factory()->create(['type' => User::ADMIN]);
        $moderator = User::factory()->create(['type' => User::MODERATOR]);
        $user = User::factory()->create();

        // admin request
        $this->actingAs($admin)
                ->post(route('admin.topics.store', $topicOneAttributes = [
                    'name' => 'Topic One',
                    'slug' => 'topic-one',
                    ])
                    )->assertRedirectToRoute('admin.topics.index');

        $this->assertDatabaseHas('topics', $topicOneAttributes);

        // moderator request
        $this->actingAs($moderator)
                ->post(route('admin.topics.store', $topicTwoAttributes = [
                    'name' => 'Topic Two',
                    'slug' => 'topic-two'
                    ]))
                ->assertRedirectToRoute('admin.topics.index');

        $this->assertDatabaseHas('topics', $topicTwoAttributes);

        // user request
        $this->actingAs($user)
                ->post(route('admin.topics.store', $topicThreeAttributes = [
                    'name' => 'Topic Three',
                    'slug' => 'topic-three'
                    ]))
                ->assertForbidden();

        $this->assertDatabaseMissing('topics', $topicThreeAttributes);
    }

    // validation test for creating topic
    public function test_validation_works_correctly_for_creating_topic()
    {
        $admin = User::factory()->create(['type' => User::ADMIN]);
        $existingTopic = Topic::create(['name' => 'Laravel', 'slug' => 'laravel']);

        // required validation test
        $response = $this->actingAs($admin)
                ->post(route('admin.topics.store', $attributes = [
                        'name' => '',
                        'slug' => '',
                        ])
                    );

        $response->assertInvalid([
            'name' => 'The name cannot be empty',
            'slug' => 'The slug cannot be empty',
        ]);
        $this->assertDatabaseMissing('topics', $attributes);

        // unique validation test
        $response = $this->actingAs($admin)->post(
                                                    route(
                                                        'admin.topics.store',
                                                        $attributes = [
                                                            'name' => 'Laravel',
                                                            'slug' => 'laravel',
                                                        ])
                                                    );

        $response->assertInvalid([
            'name' => 'The name has already been taken.',
            'slug' => 'The slug has already been taken.'
        ]);

    }

    public function test_only_admin_or_moderator_can_update_topic()
    {
        $admin = User::factory()->create(['type' => User::ADMIN]);
        $moderator = User::factory()->create(['type' => User::MODERATOR]);
        $user = User::factory()->create();

        $topicOne = Topic::create(['name' => 'Topic One', 'slug' => 'topic-one']);
        $topicTwo = Topic::create(['name' => 'Topic Two', 'slug' => 'topic-two']);
        $topicThree = Topic::create(['name' => 'Topic Three', 'slug' => 'topic-three']);

        // admin request
        $this->actingAs($admin)
                ->patch(route('admin.topics.update', ['topic' => $topicOne]), $topicOneAttributes = [
                    'name' => 'Update Topic One',
                    'slug' => 'update-topic-one'
                ])
                ->assertRedirectToRoute('admin.topics.index');

        $this->assertDatabaseHas('topics', $topicOneAttributes);

        // moderator request
        $this->actingAs($moderator)
                ->patch(route('admin.topics.update', ['topic' => $topicTwo]), $topicTwoAttributes = [
                    'name' => 'Update Topic Two',
                    'slug' => 'update-topic-two'
                ])
                ->assertRedirectToRoute('admin.topics.index');

        $this->assertDatabaseHas('topics', $topicTwoAttributes);

        // user request
        $this->actingAs($user)
                ->patch(route('admin.topics.update', ['topic' => $topicThree]), $topicThreeAttributes = [
                    'name' => 'Update Topic Three',
                    'slug' => 'update-topic-three'
                ])
                ->assertForbidden();

        $this->assertDatabaseMissing('topics', $topicThreeAttributes);
    }

    // validation test for updating topic
    public function test_validation_works_correctly_updating_topic()
    {
        $admin = User::factory()->create(['type' => User::ADMIN]);

        $topic = Topic::create(['name' => 'Topic One', 'slug' => 'topic-one']);
        $anotherTopic = Topic::create(['name' => 'Another Topic', 'slug' => 'another-topic']);

        // required
        $this->actingAs($admin)
                ->patch(route('admin.topics.update', ['topic' => $topic]), [
                    'name' => '',
                    'slug' => ''
                ])
                ->assertValid(['name' => 'The name cannot be empty', 'slug' => 'The slug cannot be empty']);

        // unique
        $this->actingAs($admin)
        ->patch(route('admin.topics.update', ['topic' => $topic]), [
            'name' => 'Another Topic',
            'slug' => 'another-topic'
        ])
        ->assertValid(['name' => 'The name has already been taken.', 'slug' => 'The slug has already been taken.']);
    }

    // delete
    public function test_only_admin_or_moderator_can_delete_topic()
    {
        $admin = User::factory()->create(['type' => User::ADMIN]);
        $moderator = User::factory()->create(['type' => User::MODERATOR]);
        $user = User::factory()->create();

        $topicOne = Topic::create(['name' => 'Topic One', 'slug' => 'topic-one']);
        $topicTwo = Topic::create(['name' => 'Topic Two', 'slug' => 'topic-two']);
        $topicThree = Topic::create(['name' => 'Topic Three', 'slug' => 'topic-three']);

        // admin request
        $this->actingAs($admin)
                ->delete(route('admin.topics.destroy', ['topic' => $topicOne]))
                ->assertRedirectToRoute('admin.topics.index');

        $this->assertDatabaseMissing('topics', [
            'name' => 'Topic One',
            'slug' => 'topic-one'
        ]);

        // moderator request
        $this->actingAs($moderator)
                ->delete(route('admin.topics.destroy', ['topic' => $topicTwo]))
                ->assertRedirectToRoute('admin.topics.index');

        $this->assertDatabaseMissing('topics', [
            'name' => 'Topic Two',
            'slug' => 'topic-two'
        ]);

        // user request
        $this->actingAs($user)
                ->delete(route('admin.topics.destroy', ['topic' => $topicThree]))
                ->assertForbidden();

        $this->assertDatabaseHas('topics', [
            'name' => 'Topic Three',
            'slug' => 'topic-three'
        ]);
    }
}
