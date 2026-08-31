<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AttachmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_multiple_attachments_to_a_post(): void
    {
        Storage::fake();

        $user = User::factory()->create();
        $community = Community::factory()->create();

        $files = [
            UploadedFile::fake()->create('notes.pdf', 100, 'application/pdf'),
            UploadedFile::fake()->create('example.txt', 50, 'text/plain'),
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'community_id' => $community->id,
                'title' => 'Post with attachments',
                'body' => 'This post contains multiple attachments.',
                'files' => $files,
            ]);

        $response->assertRedirect(route('posts.index'));

        $post = Post::firstOrFail();

        $this->assertCount(2, $post->file_paths);

        $this->assertSame(
            ['notes.pdf', 'example.txt'],
            array_column($post->file_paths, 'name')
        );

        foreach ($post->file_paths as $file) {
            $this->assertTrue(
                Storage::exists($file['path'])
            );
        }
    }

    public function test_user_can_remove_an_attachment_when_updating_a_post(): void
    {
        Storage::fake();

        $user = User::factory()->create();
        $community = Community::factory()->create();

        $this
            ->actingAs($user)
            ->post(route('posts.store'), [
                'community_id' => $community->id,
                'title' => 'Post with attachments',
                'body' => 'This post contains multiple attachments.',
                'files' => [
                    UploadedFile::fake()->create(
                        'remove-me.pdf',
                        100,
                        'application/pdf'
                    ),
                    UploadedFile::fake()->create(
                        'keep-me.txt',
                        50,
                        'text/plain'
                    ),
                ],
            ]);

        $post = Post::firstOrFail();

        $removedPath = $post->file_paths[0]['path'];
        $keptPath = $post->file_paths[1]['path'];

        $response = $this
            ->actingAs($user)
            ->patch(route('posts.update', $post), [
                'community_id' => $community->id,
                'title' => $post->title,
                'body' => $post->body,
                'remove_files' => [0],
            ]);

        $response->assertRedirect(route('posts.show', $post));

        $post->refresh();

        $this->assertCount(1, $post->file_paths);
        $this->assertSame(
            'keep-me.txt',
            $post->file_paths[0]['name']
        );

        $this->assertFalse(Storage::exists($removedPath));
        $this->assertTrue(Storage::exists($keptPath));
    }
}
