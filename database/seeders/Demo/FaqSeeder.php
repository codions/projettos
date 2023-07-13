<?php

namespace Database\Seeders\Demo;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run()
    {
        Faq::factory()
            ->count(8)
            ->create();
    }
}
