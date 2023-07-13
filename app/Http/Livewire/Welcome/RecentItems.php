<?php

namespace App\Http\Livewire\Welcome;

use App\Models\Item;
use App\Settings\GeneralSettings;
use Closure;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Livewire\Component;

class RecentItems extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        $recentItemsConfig = collect(app(GeneralSettings::class)->dashboard_items)->first();

        return Item::query()
            ->with('board.project')
            ->visibleForCurrentUser()
            ->when(Arr::get($recentItemsConfig, 'must_have_board'), function (Builder $query) {
                return $query->has('board');
            })
            ->when(Arr::get($recentItemsConfig, 'must_have_project'), function (Builder $query) {
                return $query->has('project');
            })
            ->limit(10);
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return function ($record) {
            if (! $record->board) {
                return route('items.show', $record);
            }

            return route('items.show', $record);
        };
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title')->label(trans('table.title')),
            Tables\Columns\TextColumn::make('total_votes')->label(trans('table.total-votes'))->sortable(),
            Tables\Columns\TextColumn::make('project.title')->label(trans('table.project'))
                ->url(function ($record) {
                    if ($project = $record->project) {
                        return route('projects.home', $project);
                    }

                    return null;
                }),
            Tables\Columns\TextColumn::make('board.title')->label(trans('table.board'))
                ->url(function ($record) {
                    if ($board = $record->board) {
                        return route('projects.boards.show', [$record->project, $board]);
                    }

                    return null;
                }),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    public function render()
    {
        return view('livewire.welcome.recent-items');
    }
}
