<?php

namespace Database\Seeders\Demo;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        Item::factory()
            ->count(10)
            ->create();
    }
}
