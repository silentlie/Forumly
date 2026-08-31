<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_a_post(): void
    {
        $user = User::factory()->create();
        $community = Community::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'community_id' => $community->id,
                'title' => 'My test post',
                'body' => 'This is the body of my test post.',
            ]);

        $response->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'user_id' => $user->id,
            'community_id' => $community->id,
            'title' => 'My test post',
            'body' => 'This is the body of my test post.',
        ]);
    }

    public function test_invalid_post_data_is_rejected(): void
    {
        $user = User::factory()->create();
        $community = Community::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'community_id' => $community->id,
                'title' => '',
                'body' => '',
            ]);

        $response->assertSessionHasErrors([
            'title',
            'body',
        ]);

        $this->assertDatabaseCount('posts', 0);
    }

    public function test_user_cannot_update_another_users_post(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $post = Post::factory()
            ->for($owner)
            ->create();

        $response = $this
            ->actingAs($otherUser)
            ->patch(route('posts.update', $post), [
                'community_id' => $post->community_id,
                'title' => 'Changed title',
                'body' => 'Changed body',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
        ]);
    }

    public function test_search_can_be_limited_to_post_title(): void
    {
        $titlePost = Post::factory()->create([
            'title' => 'Needle title result',
            'body' => 'This body does not contain the search term.',
        ]);

        $bodyPost = Post::factory()->create([
            'title' => 'Body only result',
            'body' => 'Needle appears in this body.',
        ]);

        $response = $this->get(route('posts.index', [
            'search' => 'Needle',
            'search_in' => 'title',
        ]));

        $response->assertOk();

        $response->assertSee($titlePost->title);
        $response->assertDontSee($bodyPost->title);
    }
}
