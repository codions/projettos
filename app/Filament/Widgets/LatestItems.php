<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ItemResource;
use App\Models\Item;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestItems extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Item::query()->visibleForCurrentUser()->latest()->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title'),
            Tables\Columns\TextColumn::make('total_votes'),
            Tables\Columns\TextColumn::make('project.title')
                ->label('Project'),
            Tables\Columns\TextColumn::make('board.title'),
        ];
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return fn ($record) => ItemResource::getUrl('edit', $record);
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
