<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Carbon\Carbon;
use Filament\Resources\Pages\Page;

class ViewTicket extends Page
{
    // Empty string to disable default header
    protected ?string $heading = '';

    protected static string $resource = TicketResource::class;

    protected static string $view = 'filament.resources.ticket.pages.view';

    public Ticket $ticket;

    public function mount(Ticket $record): void
    {
        if (is_null($record->read_at)) {
            $record->update(['read_at' => Carbon::now()]);
        }

        $this->ticket = $record;
    }
}
