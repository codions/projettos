<?php

namespace App\Filament\Resources\DocResource\Pages;

use App\Filament\Resources\DocResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;

class Index extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = DocResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableReorderColumn(): ?string
    {
        return 'order';
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return fn (Model $record): string => $record->edit_url;
    }
}
