<?php

namespace App\Notifications;

use App\Models\Ticket;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = __('Ticket Created #:id :subject', [
            'id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
        ]);

        $name = __('Name: :name', ['name' => $this->ticket->name]);
        $email = __('E-mail: :email', ['email' => $this->ticket->email]);
        $message = __('Message: :message', ['message' => $this->ticket->message]);

        return (new MailMessage)
            ->subject($subject)
            ->greeting($subject)
            ->line($name)
            ->line($email)
            ->line($message)
            ->action(__('Reply Message'), url("/admin/tickets/{$this->ticket->id}/view"))
            ->replyTo($this->ticket->email, $this->ticket->name)
            ->line(__('Thank you for using our application!'));
    }

    public function toDatabase($notifiable): array
    {
        return FilamentNotification::make()
            ->title(__('New message received #:id', ['id' => $this->ticket->id]))
            ->icon('heroicon-o-mail')
            ->actions([
                Action::make(__('View'))
                    ->button()
                    ->url(url("/admin/contacts/{$this->ticket->id}/view")),
            ])
            ->getDatabaseMessage();
    }
}
