<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class Error extends Component
{
    public ?string $logo;

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $this->logo = app(\App\Settings\ColorSettings::class)->logo;

        return view('layouts.error');
    }
}
