<?php

namespace Database\Seeders\Demo;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run()
    {
        Ticket::factory()
            ->hasReplies(4)
            ->count(50)
            ->create();
    }
}
