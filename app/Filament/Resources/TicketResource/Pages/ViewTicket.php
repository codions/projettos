<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket as Message;
use App\Notifications\TicketAnswered;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification as LaravelNotification;

class ViewTicket extends Page implements Forms\Contracts\HasForms
{
    protected static string $resource = TicketResource::class;

    protected static string $view = 'filament.resources.ticket.pages.view';

    public $state = [
        'message' => '',
        'attachments' => [],
    ];

    public Message $record;

    public Collection $replies;

    public $showReplyForm = false;

    public $previous;

    public $next;

    protected function getFormSchema(): array
    {
        return [

            RichEditor::make('state.message')
                ->columnSpan('full')
                ->required(),

            FileUpload::make('state.attachments')
                ->label(__('Attachments'))
                ->multiple()
                ->maxFiles(10)
                ->acceptedFileTypes(Message::ACCEPTED_FILE_TYPES),
        ];
    }

    public function mount(Message $record): void
    {
        $this->record = $record;

        $this->replies = $record->replies()->orderBy('id', 'desc')->get();

        if ($this->record->status === Message::UNREAD) {
            $this->record->update(['status' => Message::READ]);
        }

        $this->previous = Message::root()->where('id', '<', $record->id)->max('id');
        $this->next = Message::root()->where('id', '>', $record->id)->min('id');
    }

    public function toggleSpam()
    {
        if ($this->record->is_spam) {
            return $this->record->update(['is_spam' => false]);
        }

        return $this->record->update(['is_spam' => true]);
    }

    public function delete()
    {
        $this->record->delete();
        $this->emit('messageDeleted');

        return redirect()->to('/admin/tickets');
    }

    public function markAsUnread()
    {
        $this->record->update(['status' => Message::UNREAD]);

        return redirect()->to('/admin/tickets');
    }

    public function submit()
    {
        $this->validate();

        $contact = new Message;

        $contact->parent_id = $this->record->id;
        $contact->message = $this->state['message'];
        $status = $contact->save();

        if (! empty($this->state['attachments'])) {
            foreach ($this->state['attachments'] as $file) {
                $contact->addMedia($file)
                    ->toMediaCollection('ticket_attachments');
            }
        }

        if ($status) {
            if ($this->record->status !== Message::REPLIED) {
                $this->record->update(['status' => Message::REPLIED]);
            }

            $this->replies = $this->record
                ->replies()
                ->orderBy('id', 'desc')
                ->get();

            $this->showReplyForm = false;

            Notification::make()
                ->title(__('Your message has been sent successfully'))
                ->success()
                ->send()
                ->toDatabase();

            if ($this->record->user()->exists()) {
                $this->record->user->notify(new TicketAnswered($contact));
            } else {
                LaravelNotification::route('mail', $this->record->email)
                    ->notify(new TicketAnswered($contact));
            }
        } else {
            Notification::make()
                ->title(__('Your message could not be sent'))
                ->danger()
                ->send();
        }

        $this->state = [
            'message' => '',
            'attachments' => [],
        ];
    }
}
