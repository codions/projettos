<?php

namespace App\Filament\Resources\DocResource\Pages;

use App\Filament\Resources\DocResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class Create extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = DocResource::class;

    protected function getActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            // ...
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->record->edit_url;
    }
}
