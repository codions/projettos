<?php

namespace App\Http\Livewire\Changelog;

use App\Models\Changelog;
use Livewire\Component;

class Show extends Component
{
    public Changelog $changelog;

    public function mount($changelog)
    {
        $this->changelog = $changelog;

        abort_if($this->changelog->published_at > now(), 404);
    }

    public function render()
    {
        return view('livewire.changelog.show')
            ->layoutData([
                'breadcrumbs' => [
                    ['title' => trans('changelog.changelog'), 'url' => route('changelog')],
                    ['title' => $this->changelog->title, 'url' => route('changelog.show', $this->changelog)],
                ],
            ]);
    }
}
