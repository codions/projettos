<?php

namespace App\Http\Livewire\Tickets;

use App\Enums\UserRole;
use App\Filament\Resources\TicketResource;
use App\Filament\Resources\UserResource;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\Ticket\TicketAnswered;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Http\Livewire\Concerns\CanNotify;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Livewire\Component;

class Show extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use CanNotify;

    public $listeners = [
        'ticketReplyDeleted' => '$refresh',
        'updatedTicket' => '$refresh',
    ];

    public $state = [
        'message' => '',
        'attachments' => [],
    ];

    public Ticket $ticket;

    public Collection $replies;

    public function mount(): void
    {
        $this->replies = $this->ticket->replies()->get();
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.tickets.show');
    }

    protected function getFormSchema(): array
    {
        return [
            RichEditor::make('state.message')
                ->label(__('Your Reply'))
                ->toolbarButtons([
                    'blockquote',
                    'bold',
                    'bulletList',
                    'codeBlock',
                    'h2',
                    'h3',
                    'italic',
                    'link',
                    'orderedList',
                    'redo',
                    'strike',
                    'undo',
                ])
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

    public function delete()
    {
        $this->ticket->delete();
        $this->emit('ticketDeleted');
    }

    public function markAsUnread()
    {
        $this->ticket->update(['read_at' => null]);

        return redirect()->to(TicketResource::getUrl('index'));
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

        $this->replies = $this->ticket
            ->replies()
            ->get();

        $this->notify('success', trans('tickets.ticket-updated-by-user'));

        $users = collect([$ticket->parent->user]);

        // Move to settings (TODO: corrijir isso, o fluxo de notificação não está correto)
        if (auth()->user()->id === $ticket->user_id) {
            $users = User::whereIn('role', [UserRole::Admin->value, UserRole::Employee->value])->get();
        }

        $users->each(function (User $user) use ($ticket) {
            Notification::make()
                ->title(trans('tickets.ticket-updated-by-user'))
                ->body(trans('tickets.ticket_updated_notification_body', [
                    'user' => auth()->user()->name,
                    'title' => $ticket->title,
                ]))
                ->actions([
                    Action::make('view')->label(trans('notifications.view-item'))
                        ->url(TicketResource::getUrl('view', ['record' => $ticket])),

                    Action::make('view_user')->label(trans('notifications.view-user'))
                        ->url(UserResource::getUrl('edit', ['record' => auth()->user()])),
                ])
                ->sendToDatabase($user);

            FacadesNotification::route('mail', $user->email)
                ->notify(new TicketAnswered($ticket));
        });

        $this->state = [
            'message' => '',
            'attachments' => [],
        ];
    }
}
