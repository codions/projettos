<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Illuminate\Contracts\View\View;

class Support extends \App\Http\Livewire\Tickets\Index
{
    public $project;

    public function mount($project)
    {
        $this->project = Project::query()
            ->visibleForCurrentUser()
            ->where('slug', $project)
            ->firstOrFail();

        $this->projectId = $this->project->id;
    }

    public function render(): View
    {
        return view('livewire.projects.support')
            ->layout(\App\View\Components\Layouts\Project::class)
            ->layoutData([
                'project' => $this->project,
            ]);
    }
}
