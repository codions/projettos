<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Card extends Component
{
    public Project $project;

    public function render(): View
    {
        return view('livewire.projects.card');
    }
}
