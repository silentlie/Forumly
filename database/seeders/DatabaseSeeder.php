<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $demoUser = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
        ]);

        $users = User::factory(
            fake()->numberBetween(10, 30)
        )->create();

        $users->push($admin, $demoUser);

        $communities = Community::factory(
            fake()->numberBetween(4, 10)
        )->create();

        foreach ($communities as $community) {
            $posts = Post::factory(
                fake()->numberBetween(5, 20)
            )
                ->for($community)
                ->state(fn(array $attributes) => [
                    'user_id' => $users->random()->id,
                ])
                ->create();

            foreach ($posts as $post) {
                Comment::factory(
                    fake()->numberBetween(0, 15)
                )
                    ->for($post)
                    ->state(fn(array $attributes) => [
                        'user_id' => $users->random()->id,
                    ])
                    ->create();
            }
        }
    }
}
