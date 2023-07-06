<?php

namespace App\Filament\Resources\TicketResource\Widgets;

use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TicketStats extends BaseWidget
{
    protected function getCards(): array
    {
        $createdData = Trend::model(Ticket::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Card::make(__('Messages'), Ticket::root()->count())
                ->chart(
                    $createdData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Card::make(__('Waiting for reply'), Ticket::root()->whereIn('status', ['unread', 'read'])->count()),
            Card::make(__('Answered'), Ticket::root()->where('status', 'replied')->count()),
        ];
    }
}
