<?php

namespace Codions\FilamentCustomFields\Resources\CustomFieldResource\Pages;

use Codions\FilamentCustomFields\Resources\CustomFieldResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomFields extends ListRecords
{
    protected static string $resource = CustomFieldResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
