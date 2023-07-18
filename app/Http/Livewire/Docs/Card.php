<?php

namespace App\Http\Livewire\Docs;

use App\Models\Doc;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Card extends Component
{
    public Doc $doc;

    public function render(): View
    {
        return view('livewire.docs.card');
    }
}
