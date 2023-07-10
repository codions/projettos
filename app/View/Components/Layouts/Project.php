<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Project extends Component
{
    public function __construct(public array $breadcrumbs = [])
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.project');
    }
}
