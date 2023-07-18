<?php

namespace App\Http\Livewire\Modals\Docs;

use App\Models\Doc;
use App\Models\Project;
use DB;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use LivewireUI\Modal\ModalComponent;

class Settings extends ModalComponent implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Doc $doc;

    public ?string $slug;

    public ?int $project_id;

    public ?string $visibility;

    public function mount()
    {
        $this->fill([
            'slug' => $this->doc->slug,
            'project_id' => $this->doc->project_id,
            'visibility' => $this->doc->visibility,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(6)
                ->schema([
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->helperText($this->doc->public_url)
                        ->columnSpanFull(),

                    Forms\Components\Select::make('project_id')
                        ->label('Project')
                        ->options(Project::query()->pluck('title', 'id'))
                        ->columnSpanFull(),

                    Fieldset::make(trans('Visibility'))
                        ->schema([
                            Forms\Components\Radio::make('visibility')
                                ->label('')
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
                                ->default('public')
                                ->columnSpanFull(),
                        ])
                        ->columns(6),

                    Forms\Components\Placeholder::make('created_at')
                        ->label('Created at')
                        ->content(fn () => $this->doc->created_at->format('d-m-Y H:i:s'))
                        ->columnSpan(3),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Updated at')
                        ->content(fn () => $this->doc->updated_at->format('d-m-Y H:i:s'))
                        ->columnSpan(3),
                ]),
        ];
    }

    public function render()
    {
        return view('livewire.modals.docs.settings');
    }

    public function save()
    {
        DB::beginTransaction();

        $data = $this->form->getState();

        try {
            $this->doc->update([
                'slug' => $data['slug'],
                'project_id' => $data['project_id'],
                'visibility' => $data['visibility'],
            ]);

            DB::commit();

            $this->emit('updatedDoc');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            DB::rollback();
        }

        $this->closeModal();
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }
}
