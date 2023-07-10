<?php

namespace App\Http\Livewire\Changelog;

use App\Models\Changelog;
use App\Settings\GeneralSettings;
use Livewire\Component;

class Index extends Component
{
    public $changelogs;

    protected $listeners = [
        'item-created' => '$refresh',
    ];

    public function mount()
    {
        abort_unless(app(GeneralSettings::class)->enable_changelog, 404);

        $this->changelogs = Changelog::query()->latest()->published()->get();
    }

    public function render()
    {
        return view('livewire.changelog.index')
            ->layoutData([
                'breadcrumbs' => [
                    ['title' => trans('changelog.changelog'), 'url' => route('changelog')],
                ],
            ]);
    }
}
