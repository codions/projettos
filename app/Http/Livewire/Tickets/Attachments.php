<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Attachments extends Component
{
    public Ticket $ticket;

    public $listeners = [
        'attachmentDeleted' => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.tickets.attachments');
    }

    public function delete(Media $media)
    {
        $media->delete();
        $this->emit('attachmentDeleted');
    }
}
