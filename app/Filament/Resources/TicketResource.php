<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\Widgets;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-mail';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::root()->where('status', 'unread')->count();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(_('Name'))
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
                    ->toggleable()
                    ->searchable()
                    ->limit(20),

                Tables\Columns\TextColumn::make('replies')
                    ->label(__('Replies'))
                    ->formatStateUsing(function (string $state, Ticket $record) {
                        return $record->replies()->count();
                    }),

                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('Status'))
                    ->toggleable()
                    ->sortable()
                    ->enum([
                        'read' => __('Read'),
                        'unread' => __('Unread'),
                        'replied' => __('Replied'),
                    ])
                    ->colors([
                        'secondary' => 'read',
                        'warning' => 'unread',
                        'success' => 'replied',
                    ]),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'view' => Pages\ViewTicket::route('/{record}/view'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\TicketStats::class,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::root();
    }
}
