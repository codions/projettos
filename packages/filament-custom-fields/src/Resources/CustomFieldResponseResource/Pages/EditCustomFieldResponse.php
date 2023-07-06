<?php

namespace Codions\FilamentCustomFields\Resources\CustomFieldResponseResource\Pages;

use Codions\FilamentCustomFields\Resources\CustomFieldResponseResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomFieldResponse extends EditRecord
{
    protected static string $resource = CustomFieldResponseResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
