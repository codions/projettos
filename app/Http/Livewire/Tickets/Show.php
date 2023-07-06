<?php

namespace App\Http\Livewire\Tickets;

use App\Enums\UserRole;
use App\Filament\Resources\TicketResource;
use App\Filament\Resources\UserResource;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCreated;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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

    public $state = [
        'message' => '',
        'attachments' => [],
    ];

    public Ticket $ticket;

    public Collection $replies;

    public $showReplyForm = false;

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.tickets.show');
    }

    public function mount(): void
    {
        $this->replies = $this->ticket->replies()->orderBy('id', 'desc')->get();
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

            FileUpload::make('state.attachments')
                ->label(__('Attachments'))
                ->multiple()
                ->maxFiles(10)
                ->acceptedFileTypes(Ticket::ACCEPTED_FILE_TYPES),
        ];
    }

    public function delete()
    {
        $this->ticket->delete();
        $this->emit('messageDeleted');

        if (auth()->check()) {
            return redirect()->route('tickets');
        } else {
            return redirect()->to('/');
        }
    }

    public function submit()
    {
        $this->validate();

        $contact = new Ticket;

        $contact->parent_id = $this->ticket->id;
        $contact->message = $this->state['message'];
        $status = $contact->save();

        if (! empty($this->state['attachments'])) {
            foreach ($this->state['attachments'] as $file) {
                $contact->addMedia($file)
                    ->toMediaCollection('message_attachments');
            }
        }

        if ($status) {
            if ($this->ticket->status !== Ticket::UNREAD) {
                $this->ticket->update(['status' => Ticket::UNREAD]);
            }

            $this->replies = $this->ticket
                ->replies()
                ->orderBy('id', 'desc')
                ->get();

            $this->showReplyForm = false;

            $this->notify('success', trans('tickets.ticket_created'));

            User::query()->whereIn('role', [UserRole::Admin->value, UserRole::Employee->value])->each(function (User $user) use ($ticket) {
                Notification::make()
                    ->title(trans('tickets.ticket_created'))
                    ->body(trans('tickets.ticket_created_notification_body', ['user' => auth()->user()->name, 'title' => $ticket->title]))
                    ->actions([
                        Action::make('view')->label(trans('notifications.view-item'))->url(TicketResource::getUrl('edit', ['record' => $ticket])),
                        Action::make('view_user')->label(trans('notifications.view-user'))->url(UserResource::getUrl('edit', ['record' => auth()->user()])),
                    ])
                    ->sendToDatabase($user);

                FacadesNotification::route('mail', $user->email)
                    ->notify(new TicketCreated($ticket));
            });
        } else {
            $this->notify('danger', __('Your ticket could not be sent'));
        }

        $this->state = [
            'message' => '',
            'attachments' => [],
        ];
    }
}
