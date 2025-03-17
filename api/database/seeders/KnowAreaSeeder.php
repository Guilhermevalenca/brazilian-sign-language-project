<?php

namespace Database\Seeders;

use app/Models/KnowArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KnowAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KnowArea::factory(30)->create();
    }
}
