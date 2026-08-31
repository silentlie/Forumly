<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_normal_user_cannot_create_community(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('admin.communities.store'), [
                'name' => 'Test Community',
                'description' => 'A test community.',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('communities', [
            'name' => 'Test Community',
        ]);
    }

    public function test_admin_can_create_edit_and_delete_community(): void
    {
        $admin = User::factory()
            ->admin()
            ->create();

        // Create
        $response = $this
            ->actingAs($admin)
            ->post(route('admin.communities.store'), [
                'name' => 'Test Community',
                'description' => 'A test community.',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('communities.index'));

        $this->assertDatabaseHas('communities', [
            'name' => 'Test Community',
            'description' => 'A test community.',
        ]);

        $community = Community::where('name', 'Test Community')->firstOrFail();

        // Edit
        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.communities.update', $community), [
                'name' => 'Updated Community',
                'description' => 'Updated description.',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('communities.index'));

        $this->assertDatabaseHas('communities', [
            'id' => $community->id,
            'name' => 'Updated Community',
            'description' => 'Updated description.',
        ]);

        // Delete
        $response = $this
            ->actingAs($admin)
            ->delete(route('admin.communities.destroy', $community));

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('communities.index'));

        $this->assertDatabaseMissing('communities', [
            'id' => $community->id,
        ]);
    }
}
