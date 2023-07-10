<?php

namespace App\View\Components\Layouts;

use App\Services\Tailwind;
use App\Settings\GeneralSettings;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Base extends Component
{
    public string $brandColors;

    public array $fontFamily;

    public bool $blockRobots = false;

    public bool $userNeedsToVerify = false;

    public ?string $logo;

    public function __construct(public array $breadcrumbs = [])
    {
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

        $this->userNeedsToVerify = app(GeneralSettings::class)->users_must_verify_email &&
            auth()->check() &&
            ! auth()->user()->hasVerifiedEmail();

        $this->logo = app(\App\Settings\ColorSettings::class)->logo;

        return view('layouts.base');
    }
}
