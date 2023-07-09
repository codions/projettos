<?php

namespace App\Http\Livewire\Modals\Ticket;

use App\Models\Ticket;
use App\Settings\GeneralSettings;
use Filament\Http\Livewire\Concerns\CanNotify;
use Illuminate\Validation\Rule;
use LivewireUI\Modal\ModalComponent;
use function view;

class UpdateStatus extends ModalComponent
{
    use CanNotify;

    public Ticket $ticket;

    public $status;

    public function render()
    {
        return view('livewire.modals.ticket.update-status');
    }

    protected function rules()
    {
        $userEnabledStatuses = app(GeneralSettings::class)->statuses_enabled_for_change_by_ticket_owner;

        if (auth()->user()->hasAdminAccess()) {
            $userEnabledStatuses = array_keys(app(GeneralSettings::class)->ticket_statuses);
        }

        return [
            'status' => [
                'required',
                Rule::in($userEnabledStatuses),
            ],
        ];
    }

    public function submit()
    {
        $this->validate();

        $this->ticket->status = $this->status;
        $this->ticket->save();

        $this->emit('closeModal');
        $this->emit('updatedTicket');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }
}
