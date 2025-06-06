<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => true
        ]);

        $this->call([
            CourseSeeder::class,
            SubjectSeeder::class,
            SignSeeder::class,
            DescriptionSeeder::class,
            ExampleSeeder::class,
//            FavoriteSeeder::class,
            SuggestionSeeder::class,
            KeywordSeeder::class,
            PivotSeeder::class
        ]);
    }
}
