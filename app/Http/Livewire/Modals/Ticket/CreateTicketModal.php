<?php

namespace App\Http\Livewire\Modals\Ticket;

use function app;
use App\Enums\UserRole;
use App\Filament\Resources\TicketResource;
use App\Filament\Resources\UserResource;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCreated;
use App\Settings\GeneralSettings;
use function auth;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Http\Livewire\Concerns\CanNotify;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use LivewireUI\Modal\ModalComponent;
use function redirect;
use function route;
use function view;

class CreateTicketModal extends ModalComponent implements HasForms
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
                    TextInput::make('state.subject')
                        ->label(__('Subject'))
                        ->required()
                        ->columnSpan(6),

                    Textarea::make('state.message')
                        ->label(__('Your message'))
                        ->rows(3)
                        ->required()
                        ->columnSpan(6),

                    FileUpload::make('state.attachments')
                        ->label(__('Attachments'))
                        ->multiple()
                        ->maxFiles(10)
                        ->acceptedFileTypes(Ticket::ACCEPTED_FILE_TYPES)
                        ->columnSpan(6),
                ]),
        ];
    }

    public function submit()
    {
        if (! auth()->user()) {
            return redirect()->route('login');
        }

        if (app(GeneralSettings::class)->users_must_verify_email && ! auth()->user()->hasVerifiedEmail()) {
            $this->notify('primary', 'Please verify your email before submitting items.');

            return redirect()->route('verification.notice');
        }

        $data = $this->form->getState()['state'];

        $ticket = Ticket::create([
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);

        $ticket->user()->associate(auth()->user())->save();

        if (! empty($data['attachments'])) {
            foreach ($data['attachments'] as $file) {
                $ticket->addMedia($file)
                    ->toMediaCollection('ticket_attachments');
            }
        }

        $this->closeModal();

        $this->notify('success', trans('tickets.ticket_created'));

        User::query()->whereIn('role', [UserRole::Admin->value, UserRole::Employee->value])->each(function (User $user) use ($ticket) {
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

        return route('tickets.show', $ticket->id);
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
