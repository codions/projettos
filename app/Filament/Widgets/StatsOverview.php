<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Stats\Users::make(),
            Stats\Tickets::make(),
            Stats\Items::make(),
            Stats\Votes::make(),
        ];
    }
}
