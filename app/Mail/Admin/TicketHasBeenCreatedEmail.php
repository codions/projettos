<?php

namespace App\Mail\Admin;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketHasBeenCreatedEmail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public array $receiver,
        public Ticket $ticket
    ) {
    }

    public function build(): self
    {
        return $this
            ->to($this->receiver['webhook'], $this->receiver['name'])
            ->subject('New ticket has been created on the roadmap')
            ->markdown('emails.admin.ticket-has-been-created');
    }
}
