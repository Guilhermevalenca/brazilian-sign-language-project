<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Keyword;
use App\Models\Sign;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Keyword::factory(30)->create();
    }
}
