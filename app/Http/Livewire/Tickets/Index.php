<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Ticket;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component implements HasTable
{
    use InteractsWithTable;

    public $projectId;

    public $listeners = [
        'createdTicket' => '$refresh',
    ];

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label(__('ID'))
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),

            Tables\Columns\TextColumn::make('code')
                ->label(__('Code'))
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),

            Tables\Columns\TextColumn::make('project.title')
                ->label(trans('table.project'))
                ->toggleable(isToggledHiddenByDefault: ! empty($this->projectId)),

            Tables\Columns\TextColumn::make('subject')
                ->label(__('Subject'))
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('message')
                ->label(__('Message'))
                ->formatStateUsing(fn (string $state): string => Str::limit(strip_tags($state), 20))
                ->toggleable()
                ->searchable(),

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
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Ticket::query()
            ->owner()
            ->root()
            ->when(
                ! empty($this->projectId),
                function (Builder $query): Builder {
                    return $query->where('project_id', $this->projectId);
                },
            )
            ->with(['project']);
    }

    public function isTableSearchable(): bool
    {
        return true;
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }

    protected function getTableRecordUrlUsing()
    {
        return fn (Ticket $record): string => route('support.ticket', $record->uuid);
    }

    public function render(): View
    {
        return view('livewire.tickets.index')
            ->layoutData([
                'breadcrumbs' => [
                    ['title' => trans('support.support'), 'url' => route('support')],
                ],
            ]);
    }
}
