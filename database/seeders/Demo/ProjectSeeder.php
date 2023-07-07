<?php

namespace Database\Seeders\Demo;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        Project::factory()
            ->hasBoards(4)
            ->count(5)
            ->create();
    }
}
