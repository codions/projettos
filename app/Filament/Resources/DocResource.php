<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocResource\Pages;
use App\Models\Doc;
use App\Models\Project;
use Camya\Filament\Forms\Components\TitleWithSlugInput;
use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class DocResource extends Resource
{
    use Translatable;

    protected static ?string $model = Doc::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Manage';

    public static function getTranslatableLocales(): array
    {
        return [config('app.locale')];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    TitleWithSlugInput::make(
                        fieldTitle: 'title',
                        fieldSlug: 'slug',
                        urlPath: '/doc/',
                        urlVisitLinkLabel: 'Visit Doc',
                        titleLabel: 'Title',
                        titlePlaceholder: 'Insert the doc title...',
                        slugLabel: 'Link:',
                    ),

                    Forms\Components\RichEditor::make('description'),
                ])->columnSpan(3),

                Forms\Components\Card::make([
                    Forms\Components\Select::make('project_id')
                        ->label('Project')
                        ->options(Project::query()->pluck('title', 'id'))
                        ->reactive(),

                    Forms\Components\Radio::make('visibility')
                        ->options([
                            'public' => 'Public',
                            'unlisted' => 'Unlisted',
                            'private' => 'Private',
                        ])
                        ->descriptions([
                            'public' => 'Visible on project page to anyone',
                            'unlisted' => 'Only for whoever has the link',
                            'private' => 'Visible only to owner',
                        ])
                        ->default('public'),

                    Forms\Components\Placeholder::make('created_at')
                        ->label('Created at')
                        ->visible(fn ($record) => filled($record))
                        ->content(fn ($record) => $record->created_at->format('d-m-Y H:i:s')),
                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Updated at')
                        ->visible(fn ($record) => filled($record))
                        ->content(fn ($record) => $record->updated_at->format('d-m-Y H:i:s')),
                ])->columnSpan(1),
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('slug')->searchable()->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('project.title'),
                Tables\Columns\TextColumn::make('user.name')->toggleable(),
                Tables\Columns\TextColumn::make('title')->searchable()->wrap(),
                Tables\Columns\TextColumn::make('description')->searchable()->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\Index::route('/'),
            'create' => Pages\Create::route('/create'),
        ];
    }
}
