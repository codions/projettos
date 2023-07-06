<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use App\Notifications\TicketAnswered;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification as LaravelNotification;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ViewTicket extends Page implements Forms\Contracts\HasForms
{
    protected static string $resource = TicketResource::class;

    protected static string $view = 'filament.resources.ticket.pages.view';

    public $state = [
        'message' => '',
        'attachments' => [],
    ];

    public Ticket $ticket;

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

            SpatieMediaLibraryFileUpload::make('state.attachments')
                ->label(__('Attachments'))
                ->collection('ticket_attachments')
                ->preserveFilenames()
                ->multiple()
                ->maxFiles(10)
                ->acceptedFileTypes(Ticket::ACCEPTED_FILE_TYPES),
        ];
    }

    public function mount(Ticket $record): void
    {
        $this->ticket = $record;

        $this->replies = $record->replies()->orderBy('id', 'desc')->get();

        if ($this->ticket->status === Ticket::UNREAD) {
            $this->ticket->update(['status' => Ticket::READ]);
        }

        $this->previous = Ticket::root()->where('id', '<', $record->id)->max('id');
        $this->next = Ticket::root()->where('id', '>', $record->id)->min('id');
    }

    public function toggleSpam()
    {
        if ($this->ticket->is_spam) {
            return $this->ticket->update(['is_spam' => false]);
        }

        return $this->ticket->update(['is_spam' => true]);
    }

    public function delete()
    {
        $this->ticket->delete();
        $this->emit('messageDeleted');

        return redirect()->to('/admin/tickets');
    }

    public function markAsUnread()
    {
        $this->ticket->update(['status' => Ticket::UNREAD]);

        return redirect()->to('/admin/tickets');
    }

    public function submit()
    {
        $data = $this->form->getState()['state'];

        $ticket = Ticket::create([
            'parent_id' => $this->ticket->id,
            'message' => $data['message'],
        ]);

        $ticket->user()->associate(auth()->user())->save();
        $this->form->model($ticket)->saveRelationships(); 

        if ($this->ticket->status !== Ticket::REPLIED) {
            $this->ticket->update(['status' => Ticket::REPLIED]);
        }

        $this->replies = $this->ticket
            ->replies()
            ->orderBy('id', 'desc')
            ->get();

        $this->showReplyForm = false;

        $this->notify('success', trans('tickets.ticket-updated-by-user'));

        if ($this->ticket->user()->exists()) {
            $this->ticket->user->notify(new TicketAnswered($ticket));
        } else {
            LaravelNotification::route('mail', $this->ticket->email)
                ->notify(new TicketAnswered($ticket));
        }

        $this->state = [
            'message' => '',
            'attachments' => [],
        ];
    }
}
