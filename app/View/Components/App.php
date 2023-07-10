<?php

namespace App\View\Components;

use App\Models\Project;
use App\Services\Tailwind;
use App\Settings\GeneralSettings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class App extends Component
{
    public Collection $pinnedProjects;

    public string $brandColors;

    public ?string $logo;

    public array $fontFamily;

    public bool $blockRobots = false;

    public bool $userNeedsToVerify = false;

    public function __construct(public array $breadcrumbs = [])
    {
        $this->pinnedProjects = Project::query()
            ->visibleForCurrentUser()
            ->when(app(GeneralSettings::class)->show_projects_sidebar_without_boards === false, function ($query) {
                return $query->has('boards');
            })
            ->where('pinned', true)
            ->orderBy('sort_order')
            ->orderBy('group')
            ->orderBy('title')
            ->get();

        $this->blockRobots = app(GeneralSettings::class)->block_robots;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $tw = new Tailwind('brand', app(\App\Settings\ColorSettings::class)->primary);

        $this->brandColors = $tw->getCssFormat();

        $fontFamily = app(\App\Settings\ColorSettings::class)->fontFamily ?? 'Nunito';
        $this->fontFamily = [
            'cssValue' => $fontFamily,
            'urlValue' => Str::snake($fontFamily, '-'),
        ];

        $this->logo = app(\App\Settings\ColorSettings::class)->logo;

        $this->userNeedsToVerify = app(GeneralSettings::class)->users_must_verify_email &&
            auth()->check() &&
            ! auth()->user()->hasVerifiedEmail();

        return view('components.app');
    }
}
