<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Ticket;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Component implements HasTable
{
    use InteractsWithTable;

    public $modalCreate = false;

    protected $listeners = [
        'toggleModalCreatel' => 'toggleModalCreatel',
        'sentContactForm' => 'sentContactForm',
        'refreshComponent' => '$refresh',
    ];

    public function sentContactForm(): void
    {
        $this->modalCreate = ! $this->modalCreate;

        $this->emit('refreshComponent');
    }

    public function toggleModalCreatel(): void
    {
        $this->modalCreate = ! $this->modalCreate;
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label(__('ID'))
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),

            Tables\Columns\TextColumn::make('project.title')
                ->label(trans('table.project')),

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
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Ticket::query()
            ->root()
            ->with(['project'])
            ->where('sent_by', auth()->user()->id)
            ->latest();
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
        return fn (Ticket $record): string => route('tickets.show', $record->id);
    }

    public function render(): View
    {
        return view('livewire.tickets.index');
    }
}
