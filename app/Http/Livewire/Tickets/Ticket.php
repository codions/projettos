<?php

namespace App\Http\Livewire\Tickets;

class Ticket extends Show
{
    public function mount($uuid = null): void
    {
        $this->replies = $this->ticket->replies()->get();
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.tickets.show');
    }
}
