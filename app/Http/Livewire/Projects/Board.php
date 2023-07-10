<?php

namespace App\Http\Livewire\Projects;

use App\Models\Board as Model;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Board extends Component
{
    public $project;

    public $board;

    public function mount($project, $board)
    {
        $this->project = Project::query()
            ->visibleForCurrentUser()
            ->where('slug', $project)
            ->firstOrFail();

        abort_if($this->project->private && ! auth()->user()?->hasAdminAccess(), 404);

        $this->board = Model::query()
            ->where('slug', $board)
            ->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.projects.board')
            ->layout(\App\View\Components\Layouts\Project::class)
            ->layoutData([
                'project' => $this->project,
            ]);
    }
}
