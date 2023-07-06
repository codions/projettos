<?php

namespace App\Filament\Resources\ItemResource\RelationManagers;

use App\Filament\Resources\ChangelogResource;
use App\Settings\GeneralSettings;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Model;

class ChangelogsRelationManager extends RelationManager
{
    protected static string $relationship = 'changelogs';

    protected static ?string $recordTitleAttribute = 'title';

    public static function canViewForRecord(Model $ownerRecord): bool
    {
        return app(GeneralSettings::class)->enable_changelog;
    }

    public static function table(Table $table): Table
    {
        return ChangelogResource::table($table);
    }

    protected function canCreate(): bool
    {
        return false;
    }
}
