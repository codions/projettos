<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class SupportController extends Controller
{
    public function __invoke()
    {
        return view('support.index');
    }

    public function ticket($uuid)
    {
        $ticket = Ticket::owner()
            ->uuid($uuid)
            ->firstOrFail();

        return view('support.ticket', ['ticket' => $ticket]);
    }
}
