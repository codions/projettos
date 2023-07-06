<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class VotesRelationManager extends RelationManager
{
    protected static string $relationship = 'votes';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('subscribed')
                    ->label('Subscribed')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model.title')->label('Item'),
                Tables\Columns\TextColumn::make('model.project.title')->label('Project'),
                Tables\Columns\BooleanColumn::make('subscribed')->label('Subscribed'),
            ])
            ->filters([
                //
            ])
            ->defaultSort('created_at', 'desc');
    }

    protected function canCreate(): bool
    {
        return false;
    }
}
