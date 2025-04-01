<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Keyword;
use App\Models\Sign;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();
        $subjects = Subject::all();
        $signs = Sign::all();
        $keywords = Keyword::all();

        foreach ($courses as $course) {
            $course->subjects()->syncWithoutDetaching($subjects->pluck('id'));
            $course->keywords()->syncWithoutDetaching($keywords->pluck('id'));
        }

        foreach ($subjects as $subject) {
            $subject->signs()->syncWithoutDetaching($signs->pluck('id'));
            $subject->keywords()->syncWithoutDetaching($keywords->pluck('id'));
        }

        foreach ($signs as $sign) {
            $sign->keywords()->syncWithoutDetaching($keywords->pluck('id'));
        }
    }
}
