<?php

namespace App\Http\Livewire\Projects\Changelog;

use App\Models\Project;
use App\Settings\GeneralSettings;
use Livewire\Component;

class Index extends Component
{
    public $project;

    public $changelogs;

    protected $listeners = [
        'item-created' => '$refresh',
    ];

    public function mount($project)
    {
        abort_unless(app(GeneralSettings::class)->enable_changelog, 404);

        $this->project = Project::query()
            ->visibleForCurrentUser()
            ->where('slug', $project)
            ->firstOrFail();

        $this->changelogs = $this->project->changelogs()->latest()->published()->get();
    }

    public function render()
    {
        return view('livewire.projects.changelog.index')
            ->layout(\App\View\Components\Layouts\Project::class)
            ->layoutData([
                'project' => $this->project,
            ]);
    }
}
