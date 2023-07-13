<?php

namespace App\Http\Livewire\Items;

use App\Enums\ItemActivity;
use App\Models\Item;
use App\Settings\GeneralSettings;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Show extends Component
{
    public $project;

    public $board;

    public $item;

    public $user;

    public $activities;

    public function mount($item)
    {
        $this->item = Item::query()->visibleForCurrentUser()->where('slug', $item)->firstOrFail();

        $showGitHubLink = app(GeneralSettings::class)->show_github_link;

        $this->activities = $this->item->activities()->with('causer')->latest()->limit(10)->get()->filter(function (Activity $activity) use ($showGitHubLink) {
            if (! $showGitHubLink && ItemActivity::getForActivity($activity) === ItemActivity::LinkedToIssue) {
                return false;
            }

            return true;
        })->map(function (Activity $activity) {
            $itemActivity = ItemActivity::getForActivity($activity);

            if ($itemActivity !== null) {
                $activity->description = $itemActivity->getTranslation($activity->properties->get('attributes'));
            }

            return $activity;
        });

        $this->project = $this->item->project;
        $this->board = $this->item->board;
        $this->item = $this->item->load('tags');
        $this->user = $this->item->user;
    }

    public function render(): View
    {
        $layout = $this->project
            ? \App\View\Components\Layouts\Project::class
            : \App\View\Components\Layouts\App::class;

        return view('livewire.item.show')
            ->layout($layout)
            ->layoutData([
                'project' => $this->project,
                'breadcrumbs' => [
                    ['title' => $this->project->title, 'url' => route('projects.home', $this->project)],
                    ['title' => $this->board->title, 'url' => route('projects.boards.show', [$this->project, $this->board])],
                    ['title' => $this->item->title, 'url' => route('items.show', $this->item)],
                ],
            ]);
    }
}
