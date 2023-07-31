<?php

namespace App\View\Components\Dropdown;

use Illuminate\View\Component;

class Item extends Component
{
    public bool $separator;

    public ?string $label;

    public ?string $icon;

    public function __construct(
        bool $separator = false,
        string $label = null,
        string $icon = null
    ) {
        $this->separator = $separator;
        $this->label = $label;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.dropdown.item');
    }
}
