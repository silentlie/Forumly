<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Community::factory()->create([
            'name' => 'General',
            'description' => 'General discussion about anything that does not fit into another community.',
        ]);

        Community::factory()->create([
            'name' => 'Programming',
            'description' => 'Discuss programming, software development, frameworks, tools, and coding.',
        ]);

        Community::factory()->create([
            'name' => 'Gaming',
            'description' => 'Discuss games, gaming news, recommendations, and related topics.',
        ]);

        Community::factory()->create([
            'name' => 'University',
            'description' => 'Discuss university life, study, courses, assignments, and student experiences.',
        ]);
    }
}
