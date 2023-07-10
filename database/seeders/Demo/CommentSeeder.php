<?php

namespace Database\Seeders\Demo;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Comment::factory()
            ->hasComments(4)
            ->count(20)
            ->create();
    }
}
