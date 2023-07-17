<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use App\Models\Project;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Manage';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Project')
                    ->options(Project::query()->pluck('title', 'id'))
                    ->required()
                    ->columnSpan(6),

                Forms\Components\TextInput::make('question')
                    ->label(__('Question'))
                    ->required()
                    ->columnSpan(6),

                Forms\Components\MarkdownEditor::make('answer')
                    ->label(__('Answer'))
                    ->columnSpan('full')
                    ->required()
                    ->columnSpan(6),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.title')
                    ->label(__('Project')),

                Tables\Columns\TextColumn::make('question')
                    ->label(__('Question'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('excerpt')
                    ->label(__('Answer'))
                    ->searchable()
                    ->limit(40),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaqs::route('/'),
        ];
    }
}
