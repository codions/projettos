<?php

namespace Codions\FilamentCustomFields\Resources\CustomFieldResource\Pages;

use Codions\FilamentCustomFields\Resources\CustomFieldResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomField extends CreateRecord
{
    protected static string $resource = CustomFieldResource::class;
}
