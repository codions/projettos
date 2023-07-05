<?php

namespace App\Spotlight;

use Illuminate\Http\Request;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewProfile extends SpotlightCommand
{
    public function getName(): string
    {
        return trans('spotlight.profile.name');
    }

    public function getDescription(): string
    {
        return trans('spotlight.profile.description');
    }

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirect(route('profile'));
    }

    public function shouldBeShown(Request $request): bool
    {
        return (bool)$request->user();
    }
}
