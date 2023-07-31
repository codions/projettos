<?php

namespace App\Http\Livewire\Docs;

use App\Models\Doc;
use App\Models\Project;
use DB;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Notifications\Notification;
use Livewire\Component;

class Edit extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public string $locale;

    public Doc $doc;

    public ?string $title;

    public ?string $slug;

    public ?string $description;

    public ?int $project_id;

    public ?string $visibility;

    public bool $editSlug = false;

    protected $listeners = ['save'];

    public function mount()
    {
        $this->fill([
            'title' => $this->doc->title,
            'slug' => $this->doc->slug,
            'description' => $this->doc->description,
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
                        ->hidden(! $this->editSlug)
                        ->columnSpanFull(),

                    RichEditor::make('description')
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
        return view('livewire.docs.edit');
    }

    public function save()
    {
        DB::beginTransaction();

        $state = $this->form->getState();

        $data = [
            'title' => $this->title,
            'description' => $state['description'],
            'project_id' => $state['project_id'],
            'visibility' => $state['visibility'],
        ];

        if (isset($state['slug'])) {
            $data['slug'] = $state['slug'];
        }

        try {
            $this->doc->update($data);

            DB::commit();

            $this->emit('updatedDoc');

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            DB::rollback();
        }
    }

    public function duplicate()
    {
        $new = $this->doc->duplicateWithVersions();

        return redirect()->to($new->edit_url);
    }

    public function delete()
    {
        if (! $this->doc->canBeDeleted()) {
            return Notification::make()
                ->title(__('Request failed'))
                ->body(__('You can only delete your own docs.'))
                ->danger()
                ->send();
        }

        $this->doc->delete();

        return redirect()->route('docs.index');
    }
}
