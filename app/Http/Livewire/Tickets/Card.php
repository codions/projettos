<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Ticket;
use Livewire\Component;

class Card extends Component
{
    public Ticket $ticket;

    public $listeners = [
        'attachmentDeleted' => '$refresh',
        'updatedTicket' => '$refresh',
    ];

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.tickets.card');
    }

    public function delete()
    {
        $this->ticket->delete();
        $this->emit('ticketReplyDeleted');
    }
}
