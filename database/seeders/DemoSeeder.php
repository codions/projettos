<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            Demo\UserSeeder::class,
            Demo\ProjectSeeder::class,
            Demo\TicketSeeder::class,
            Demo\ItemSeeder::class,
            Demo\CommentSeeder::class,
        ]);
    }
}
