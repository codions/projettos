<?php

namespace App\Http\Livewire\Items;

use App\Models\Item;
use App\Models\Project;
use Livewire\Component;

class Card extends Component
{
    public Item $item;

    public Project $project;

    public int $comments = 0;

    public function mount()
    {
        $this->project = $this->item->board->project;
    }

    public function toggleUpvote()
    {
        $this->item->toggleUpvote();
        $this->item = $this->item->refresh();
    }

    public function render()
    {
        $this->comments = $this->item->comments()->count();

        return view('livewire.board.item-card');
    }
}
