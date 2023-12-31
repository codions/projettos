<?php

namespace App\Notifications\Ticket;

use App\Models\Ticket;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class TicketAnswered extends Notification implements ShouldQueue
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $parent = $this->ticket->parent;

        $subject = __('Your ticket #:code has been answered', ['code' => $parent->code]);

        $mail = (new MailMessage)
            ->subject($subject)
            ->greeting($parent->subject)
            ->line(__('Answered by: :name', ['name' => $this->ticket->user->name]))
            ->line(new HtmlString($this->ticket->message))
            ->action(__('Reply Message'), route('support.ticket', $parent->uuid))
            ->line(__('Thank you for using our application!'));

        if ($this->ticket->getAttachments()) {
            foreach ($this->ticket->getAttachments() as $attachment) {
                $mail->attach($attachment->getPath(), [
                    'as' => $attachment->name,
                    'mime' => $attachment->mime,
                ]);
            }
        }

        return $mail;
    }

    public function toDatabase($notifiable): array
    {
        $parent = $this->ticket->parent;

        return FilamentNotification::make()
            ->title(__('Your ticket #:code has been answered', ['code' => $parent->code]))
            ->icon('heroicon-o-mail')
            ->actions([
                Action::make(__('View'))
                    ->button()
                    ->url(route('support.ticket', $parent->uuid), shouldOpenInNewTab: true),
            ])
            ->getDatabaseMessage();
    }
}
