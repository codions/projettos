<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Manage';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::root()->whereNull('read_at')->count();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('code')
                    ->label(__('Code'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('project.title')->label(trans('table.project'))
                    ->url(function ($record) {
                        if ($project = $record->project) {
                            return ProjectResource::getUrl('edit', ['record' => $project]);
                        }

                        return null;
                    }),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(_('User'))
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->view('filament.tables.columns.user-card'),

                Tables\Columns\TextColumn::make('subject')
                    ->label(__('Subject'))
                    ->toggleable()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('message')
                    ->label(__('Message'))
                    ->formatStateUsing(fn (string $state): string => Str::limit(strip_tags($state), 20))
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('Status'))
                    ->toggleable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'view' => Pages\ViewTicket::route('/{record}/view'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::root()
            ->with(['project']);
    }
}
