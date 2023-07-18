<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Faqs extends Component
{
    use WithPagination;

    public $tableRecordsPerPage = 32;

    public $project;

    public function mount($project)
    {
        $this->project = Project::query()
            ->visibleForCurrentUser()
            ->where('slug', $project)
            ->firstOrFail();
    }

    public function showPagination(): bool
    {
        return $this->project->faqs->count() > $this->tableRecordsPerPage;
    }

    public function getFaqs()
    {
        return $this->project->faqs()
            ->orderBy('order')
            ->paginate($this->tableRecordsPerPage);
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
