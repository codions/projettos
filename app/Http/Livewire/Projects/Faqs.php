<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Faqs extends Component
{
    public $project;

    public function mount($project)
    {
        $this->project = Project::query()
            ->visibleForCurrentUser()
            ->where('slug', $project)
            ->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.projects.faqs')
            ->layout(\App\View\Components\Layouts\Project::class)
            ->layoutData([
                'project' => $this->project,
            ]);
    }
}
