<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UsersChart extends BaseChart
{
    protected static ?string $heading = 'Users';

    protected function getData(): array
    {
        $datasets = [];
        $labels = [];

        $info = $this->getFiltersInfo();

        $start = $info['start'];
        $end = $info['end'];
        $per = $info['per'];
        $format = $info['format'];

        $data = Trend::model(User::class)
            ->between(
                start: $start,
                end: $end,
            )
            ->{$per}()
            ->count();

        $datasets[] = [
            'label' => 'Users',
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
