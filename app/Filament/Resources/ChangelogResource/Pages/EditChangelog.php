<?php

namespace App\Filament\Resources\ChangelogResource\Pages;

use App\Filament\Resources\ChangelogResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditChangelog extends EditRecord
{
    protected static string $resource = ChangelogResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        $record->storeData([
            'board_ids' => $data['board_ids'],
            'item_ids' => $data['item_ids'],
        ]);

        return $record;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
