<?php

namespace App\Filament\Widgets\Stats;

use Filament\Widgets\StatsOverviewWidget\Card;

abstract class BaseStat
{
    protected $model;

    protected $labelSingular;

    protected $labelPlural;

    abstract public static function make();

    public function getQuery()
    {
        return $this->model::query();
    }

    public function getCard(): Card
    {
        $percentageChange = $this->getNewUsersPercentageChange();

        return Card::make($this->labelPlural, $this->getNewUsersCountThisMonth() . ' this month')
            ->description(abs(round($percentageChange)) . ($percentageChange > 0 ? '% increase' : '% decrease'))
            ->chart(array_values($this->getNewUsersCountPerMonth()))
            ->descriptionIcon($percentageChange >= 0 ? 'heroicon-s-trending-up' : 'heroicon-s-trending-down')
            ->color($percentageChange >= 0 ? 'success' : 'danger');
    }

    protected function getNewUsersCountPerMonth(): array
    {
        return $this->getQuery()->selectRaw('COUNT(*) as count, MONTH(created_at) as month')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->all();
    }

    protected function getNewUsersCountThisMonth(): int
    {
        return $this->getQuery()->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
    }

    protected function getNewUsersCountLastMonth(): int
    {
        return $this->getQuery()->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();
    }

    protected function getNewUsersPercentageChange(): float
    {
        $lastMonthCount = $this->getNewUsersCountLastMonth();
        $thisMonthCount = $this->getNewUsersCountThisMonth();

        // Prevent division by zero
        if ($lastMonthCount === 0) {
            return $thisMonthCount === 0 ? 0 : 100;
        }

        $percentageChange = (($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100;

        return $percentageChange;
    }
}
