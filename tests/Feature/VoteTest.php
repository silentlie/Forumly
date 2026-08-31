<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_toggle_vote_on_and_off(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        // Vote.
        $response = $this
            ->actingAs($user)
            ->postJson(route('posts.vote', $post));

        $response
            ->assertOk()
            ->assertJson([
                'voted' => true,
                'count' => 1,
            ]);

        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        // Remove vote.
        $response = $this
            ->actingAs($user)
            ->postJson(route('posts.vote', $post));

        $response
            ->assertOk()
            ->assertJson([
                'voted' => false,
                'count' => 0,
            ]);

        $this->assertDatabaseMissing('votes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    public function test_guest_cannot_vote(): void
    {
        $post = Post::factory()->create();

        $response = $this
            ->postJson(route('posts.vote', $post));

        $response->assertUnauthorized();

        $this->assertDatabaseMissing('votes', [
            'post_id' => $post->id,
        ]);
    }
}
