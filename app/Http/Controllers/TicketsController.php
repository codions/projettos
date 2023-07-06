<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class TicketsController extends Controller
{
    public function __invoke()
    {
        return view('tickets.index');
    }

    public function show($id)
    {
        $ticket = Ticket::where('sent_by', auth()->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('tickets.show', ['ticket' => $ticket]);
    }
}
