<?php

namespace Codions\FilamentCustomFields\Resources\CustomFieldResource\Pages;

use Codions\FilamentCustomFields\Resources\CustomFieldResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomField extends EditRecord
{
    protected static string $resource = CustomFieldResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
