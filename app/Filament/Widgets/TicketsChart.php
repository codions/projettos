<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TicketsChart extends BaseChart
{
    protected static ?string $heading = 'Tickets';

    protected function getData(): array
    {
        $datasets = [];
        $labels = [];

        $info = $this->getFiltersInfo();

        $start = $info['start'];
        $end = $info['end'];
        $per = $info['per'];
        $format = $info['format'];

        $data = Trend::query(Ticket::root())
            ->between(
                start: $start,
                end: $end,
            )
            ->{$per}()
            ->count();

        $datasets[] = [
            'label' => 'Tickets',
            'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
        ];

        // Save the labels from the first dataset
        if (empty($labels)) {
            $labels = $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format($format));
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }
}
