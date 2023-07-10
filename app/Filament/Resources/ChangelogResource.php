<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChangelogResource\Pages;
use App\Models\Changelog;
use App\Models\Item;
use App\Models\Project;
use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ChangelogResource extends Resource
{
    protected static ?string $model = Changelog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rss';

    protected static ?string $navigationGroup = 'Manage';

    protected static ?string $navigationLabel = 'Changelog';

    protected static ?string $recordTitleAttribute = 'title';

    protected static function shouldRegisterNavigation(): bool
    {
        return app(GeneralSettings::class)->enable_changelog;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\DateTimePicker::make('published_at'),

                    Forms\Components\MarkdownEditor::make('content')
                        ->columnSpan(2)
                        ->required()
                        ->minLength(5)
                        ->maxLength(65535),
                ])->columnSpan(4),

                Forms\Components\Card::make([
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->label('Author')
                        ->default(auth()->user()->id)
                        ->preload()
                        ->required()
                        ->searchable(),

                    Forms\Components\Select::make('project_id')
                        ->label('Project')
                        ->options(Project::query()->pluck('title', 'id'))
                        ->reactive()
                        ->required(),

                    Forms\Components\Select::make('board_ids')
                        ->multiple()
                        ->label(trans('table.board'))
                        ->visible(fn ($get) => $get('project_id'))
                        ->options(function ($get) {
                            return Project::find($get('project_id'))->boards()->pluck('title', 'id');
                        })
                        ->reactive()
                        ->required(),

                    Forms\Components\Fieldset::make(trans('projects.changelog.related_items'))
                        ->schema([
                            Forms\Components\CheckboxList::make('item_ids')
                                ->label(trans('projects.changelog.tasks'))
                                ->options(function ($get) {
                                    return Item::whereIn('board_id', $get('board_ids'))->pluck('items.title', 'items.id');
                                })
                                ->bulkToggleable(),
                        ])
                        ->visible(fn ($get) => $get('board_ids')),
                ])->columnSpan(2),
            ])->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.title')->label(trans('table.project'))
                    ->url(function ($record) {
                        if ($project = $record->project) {
                            return ProjectResource::getUrl('edit', ['record' => $project]);
                        }

                        return null;
                    }),

                Tables\Columns\TextColumn::make('title')->searchable()->wrap(),
                Tables\Columns\IconColumn::make('published')
                    ->boolean()
                    ->getStateUsing(fn ($record) => filled($record->published_at) && now()->greaterThanOrEqualTo($record->published_at)),
                Tables\Columns\TextColumn::make('published_at')->dateTime()->since()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_published')
                    ->query(fn (Builder $query): Builder => $query->where('published_at', '<=', now())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListChangelogs::route('/'),
            'create' => Pages\CreateChangelog::route('/create'),
            'edit' => Pages\EditChangelog::route('/{record}/edit'),
        ];
    }
}
