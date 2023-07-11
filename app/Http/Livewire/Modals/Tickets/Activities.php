<?php

namespace App\Http\Livewire\Modals\Tickets;

use App\Enums\TicketActivity;
use App\Models\Ticket;
use App\Settings\GeneralSettings;
use LivewireUI\Modal\ModalComponent;
use Spatie\Activitylog\Models\Activity;
use function view;

class Activities extends ModalComponent
{
    public $ticket;

    public function mount()
    {
        $this->ticket = Ticket::query()->findOrFail($this->ticket);
    }

    public function render()
    {
        return view('livewire.modals.tickets.activities');
    }

    public function getActivities()
    {
        $showGitHubLink = app(GeneralSettings::class)->show_github_link;

        $activities = $this->ticket->activities()->with('causer')->latest()->limit(10)->get()->filter(function (Activity $activity) use ($showGitHubLink) {
            if (! $showGitHubLink && TicketActivity::getForActivity($activity) === TicketActivity::LinkedToIssue) {
                return false;
            }

            return true;
        })->map(function (Activity $activity) {
            $TicketActivity = TicketActivity::getForActivity($activity);

            if ($TicketActivity !== null) {
                $activity->description = $TicketActivity->getTranslation($activity->properties->get('attributes'));
            }

            return $activity;
        });

        return $activities;
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }
}
