<?php

namespace App\Filament\Resources\ChangelogResource\Pages;

use App\Filament\Resources\ChangelogResource;
use App\Models\Changelog;
use Filament\Resources\Pages\CreateRecord;

class CreateChangelog extends CreateRecord
{
    protected static string $resource = ChangelogResource::class;

    protected function handleRecordCreation(array $data): Changelog
    {
        $changelog = static::getModel()::create($data);

        $changelog->storeData([
            'board_ids' => $data['board_ids'],
            'item_ids' => $data['item_ids'],
        ]);

        return $changelog;
    }
}
