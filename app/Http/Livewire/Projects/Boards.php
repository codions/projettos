<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Boards extends Component
{
    public $project;

    public $boards;

    public function mount($project)
    {
        $this->project = Project::query()
            ->visibleForCurrentUser()
            ->where('slug', $project)
            ->firstOrFail();

        $this->boards = $this->project->boards()
            ->visible()
            ->with(['items' => function ($query) {
                return $query
                    ->orderBy('pinned', 'desc')
                    ->visibleForCurrentUser()
                    ->popular() // TODO: This needs to be fixed to respect the sorting setting from the board itself (sort_items_by)
                    ->withCount('votes');
            }])
            ->get();
    }

    public function render(): View
    {
        return view('livewire.projects.boards')
            ->layout(\App\View\Components\Layouts\Project::class)
            ->layoutData([
                'project' => $this->project,
            ]);
    }
}
