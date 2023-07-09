<?php

namespace App\Notifications\Ticket;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Ticket $ticket
    ) {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(trans('notifications.ticket-updated-subject', ['subject' => $this->ticket->subject]))
            ->markdown('emails.ticket.updated', [
                'user' => $notifiable,
                'ticket' => $this->ticket,
                'activities' => $this->ticket->activities()->latest()->limit(2)->get(),
            ]);
    }
}
