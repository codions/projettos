<?php

namespace App\Http\Livewire\Projects\Changelog;

use App\Models\Changelog;
use App\Models\Project;
use Livewire\Component;

class Show extends Component
{
    public $project;

    public Changelog $changelog;

    public function mount($project, $changelog)
    {
        abort_if($this->changelog->published_at > now(), 404);

        $this->project = Project::query()
            ->visibleForCurrentUser()
            ->where('slug', $project)
            ->firstOrFail();

        $this->changelog = $changelog;
    }

    public function render()
    {
        return view('livewire.projects.changelog.show')
            ->layout(\App\View\Components\Layouts\Project::class)
            ->layoutData([
                'project' => $this->project,
            ]);
    }
}
