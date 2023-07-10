<?php

namespace App\Http\Livewire\Modals\Ticket;

use function app;
use App\Enums\UserRole;
use App\Filament\Resources\TicketResource;
use App\Filament\Resources\UserResource;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\Ticket\TicketCreated;
use App\Settings\GeneralSettings;
use function auth;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Http\Livewire\Concerns\CanNotify;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use LivewireUI\Modal\ModalComponent;
use function redirect;
use function view;

class Create extends ModalComponent implements HasForms
{
    use InteractsWithForms;
    use CanNotify;

    public $state = [
        'attachments' => [],
    ];

    public function mount()
    {
        $this->form->fill([]);
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(6)
                ->schema([
                    Select::make('state.project_id')
                        ->label(trans('table.project'))
                        ->options(Project::query()->visibleForCurrentUser()->pluck('title', 'id'))
                        ->required()
                        ->columnSpan(6),

                    TextInput::make('state.subject')
                        ->label(__('Subject'))
                        ->required()
                        ->columnSpan(6),

                    RichEditor::make('state.message')
                        ->label(__('Your Message'))
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
                        ->required()
                        ->columnSpan(6),

                    SpatieMediaLibraryFileUpload::make('state.attachments')
                        ->label(__('Attachments'))
                        ->collection('ticket_attachments')
                        ->preserveFilenames()
                        ->multiple()
                        ->maxFiles(10)
                        ->acceptedFileTypes(Ticket::ACCEPTED_FILE_TYPES)
                        ->columnSpan(6),
                ]),
        ];
    }

    public function submit()
    {
        if (app(GeneralSettings::class)->users_must_verify_email && ! auth()->user()->hasVerifiedEmail()) {
            $this->notify('primary', 'Please verify your email before submitting items.');

            return redirect()->route('verification.notice');
        }

        $data = $this->form->getState()['state'];

        $ticket = Ticket::create([
            'project_id' => $data['project_id'] ?? null,
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);

        $ticket->user()->associate(auth()->user())->save();
        $this->form->model($ticket)->saveRelationships();

        $this->closeModal();

        $this->notify('success', trans('tickets.ticket_created'));

        User::whereIn('role', [UserRole::Admin->value, UserRole::Employee->value])->each(function (User $user) use ($ticket) {
            Notification::make()
                ->title(trans('tickets.ticket_created'))
                ->body(trans('tickets.ticket_created_notification_body', ['user' => auth()->user()->name, 'title' => $ticket->title]))
                ->actions([
                    Action::make('view')->label(trans('notifications.view-item'))->url(TicketResource::getUrl('view', ['record' => $ticket])),
                    Action::make('view_user')->label(trans('notifications.view-user'))->url(UserResource::getUrl('edit', ['record' => auth()->user()])),
                ])
                ->sendToDatabase($user);

            FacadesNotification::route('mail', $user->email)
                ->notify(new TicketCreated($ticket));
        });

        $this->emit('createdTicket');

        return redirect()->route('support.ticket', $ticket->uuid);
    }

    public function render()
    {
        return view('livewire.modals.ticket.create');
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }
}