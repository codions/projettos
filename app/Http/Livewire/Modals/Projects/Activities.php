<?php

namespace App\Http\Livewire\Modals\Projects;

use App\Enums\TicketActivity;
use App\Models\Project;
use App\Settings\GeneralSettings;
use LivewireUI\Modal\ModalComponent;
use Spatie\Activitylog\Models\Activity;
use function view;

class Activities extends ModalComponent
{
    public Project $project;

    public function render()
    {
        return view('livewire.modals.projects.activities');
    }

    public function getActivities()
    {
        $showGitHubLink = app(GeneralSettings::class)->show_github_link;

        $activities = $this->project->activities()->with('causer')->latest()->limit(10)->get()->map(function (Activity $activity) {
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
