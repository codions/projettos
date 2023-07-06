<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditComment extends EditRecord
{
    protected static string $resource = CommentResource::class;

    public function getActions(): array
    {
        return [
            Action::make('view_public')
                ->color('secondary')
                ->openUrlInNewTab()
                ->url(fn () => route('items.show', $this->record->item) . '#comment-' . $this->record->id),
            ...parent::getActions(),
        ];
    }
}
