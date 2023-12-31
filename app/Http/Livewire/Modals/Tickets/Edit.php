<?php

namespace App\Http\Livewire\Modals\Tickets;

use function app;
use App\Models\Project;
use App\Models\Ticket;
use App\Settings\GeneralSettings;
use Codions\FilamentCustomFields\CustomFields\FilamentCustomFieldsHelper;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Http\Livewire\Concerns\CanNotify;
use LivewireUI\Modal\ModalComponent;
use function view;

class Edit extends ModalComponent implements HasForms
{
    use InteractsWithForms;
    use CanNotify;

    public Ticket $ticket;

    public $state = [
        'attachments' => [],
    ];

    public function mount()
    {
        $this->form->fill(['state' => [
            'project_id' => $this->ticket->project_id,
            'status' => $this->ticket->status,
            'subject' => $this->ticket->subject,
            'message' => $this->ticket->message,
        ]]);
    }

    protected function getFormSchema(): array
    {
        $statuses = [];
        foreach (app(GeneralSettings::class)->ticket_statuses as $key => $status) {
            $statuses[$key] = $status['label'];
        }

        $customField = ($this->ticket->is_root)
            ? FilamentCustomFieldsHelper::customFieldsForm(Ticket::class, $this->ticket->id)
            : [];

        return [
            Grid::make(6)
                ->schema([
                    Select::make('state.project_id')
                        ->label(trans('table.project'))
                        ->options(Project::query()->visibleForCurrentUser()->pluck('title', 'id'))
                        ->required()
                        ->hidden((! auth()->user()->hasAdminAccess()) || ! $this->ticket->is_root)
                        ->columnSpan(3),

                    Select::make('state.status')
                        ->label(trans('Status'))
                        ->options($statuses)
                        ->required()
                        ->hidden((! auth()->user()->hasAdminAccess()) || ! $this->ticket->is_root)
                        ->columnSpan(3),

                    TextInput::make('state.subject')
                        ->label(__('Subject'))
                        ->required()
                        ->hidden(! $this->ticket->is_root)
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
                            'strike',
                        ])
                        ->required()
                        ->columnSpan(6),

                    ...$customField,
                ]),
        ];
    }

    public function submit()
    {
        if (! $this->ticket->canBeEdited()) {
            $this->notify('danger', 'You can only edit your own tickets');
        }

        $data = $this->form->getState();

        $this->ticket->update([
            'project_id' => $data['state']['project_id'] ?? $this->ticket->project_id,
            'status' => $data['state']['status'] ?? $this->ticket->status,
            'subject' => $data['state']['subject'] ?? $this->ticket->subject,
            'message' => $data['state']['message'],
        ]);

        FilamentCustomFieldsHelper::handleCustomFieldsRequest($data, Ticket::class, $this->ticket->id);

        $this->closeModal();
        $this->emit('updatedTicket');

        $this->notify('success', trans('tickets.ticket_updated'));
    }

    public function render()
    {
        return view('livewire.modals.tickets.edit');
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
