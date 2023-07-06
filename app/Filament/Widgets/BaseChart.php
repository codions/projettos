<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;

abstract class BaseChart extends LineChartWidget
{
    public ?string $filter = 'year';

    protected function getFilters(): ?array
    {
        return [
            'today' => __('Today'),
            'week' => __('Last week'),
            'month' => __('Last month'),
            'year' => __('This year'),
        ];
    }

    protected function getFiltersInfo()
    {
        switch ($this->filter) {
            case 'today':
                $start = now()->startOfDay();
                $end = now()->endOfDay();
                $per = 'perHour';
                $format = 'H';

                break;
            case 'week':
                $start = now()->startOfWeek();
                $end = now()->endOfWeek();
                $per = 'perDay';
                $format = 'D';

                break;
            case 'month':
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
                $per = 'perDay';
                $format = 'j';

                break;
            case 'year':
            default:
                $start = now()->startOfYear();
                $end = now()->endOfYear();
                $per = 'perMonth';
                $format = 'M';

                break;
        }

        return [
            'start' => $start,
            'end' => $end,
            'per' => $per,
            'format' => $format,
        ];
    }
}
