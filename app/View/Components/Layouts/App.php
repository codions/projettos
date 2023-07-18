<?php

namespace App\View\Components\Layouts;

use App\Models\Project;
use App\Settings\GeneralSettings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class App extends Component
{
    public Collection $pinnedProjects;

    public function __construct(public array $breadcrumbs = [])
    {
        $this->pinnedProjects = Project::query()
            ->visibleForCurrentUser()
            ->when(app(GeneralSettings::class)->show_projects_sidebar_without_boards === false, function ($query) {
                return $query->has('boards');
            })
            ->where('pinned', true)
            ->orderBy('order')
            ->orderBy('group')
            ->orderBy('title')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.app');
    }
}
