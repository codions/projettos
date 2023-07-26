<?php

namespace App\Http\Livewire\Modals\Docs\Pages;

use App\Models\Doc;
use App\Models\DocPage;
use App\Models\DocVersion;
use App\Models\Project;
use DB;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use LivewireUI\Modal\ModalComponent;

class Settings extends ModalComponent implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public DocPage $page;

    public $title;

    public $slug;

    public $doc_id;

    public $parent_id;

    public $version_id;

    public $project_id;

    public $visibility;

    public function mount()
    {
        $this->fill([
            'title' => $this->page->title,
            'slug' => $this->page->slug,
            'doc_id' => $this->page->doc_id,
            'parent_id' => $this->page->parent_id,
            'version_id' => $this->page->version_id,
            'project_id' => $this->page->project_id,
            'visibility' => $this->page->visibility,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(6)
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label(trans('Title'))
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('slug')
                        ->label(trans('Slug'))
                        ->required()
                        ->columnSpanFull()
                        ->helperText($this->page->public_url),

                    Section::make(trans('Visibility'))
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
                        ->collapsed()
                        ->columns(6),

                    Section::make(trans('Positioning'))
                        ->schema([
                            Forms\Components\Select::make('project_id')
                                ->label('Project')
                                ->options(Project::query()->pluck('title', 'id'))
                                ->reactive()
                                ->columnSpanFull(),

                            Forms\Components\Select::make('doc_id')
                                ->label('Doc')
                                ->options(function ($get) {
                                    if ($get('project_id')) {
                                        return Project::find($get('project_id'))?->docs()->pluck('title', 'id') ?? [];
                                    }

                                    return Doc::all()->pluck('title', 'id') ?? [];
                                })
                                ->reactive()
                                ->required()
                                ->columnSpanFull(),

                            Forms\Components\Select::make('version_id')
                                ->label('Version')
                                ->options(function ($get) {
                                    return DocVersion::where('doc_id', $get('doc_id'))
                                        ->pluck('title', 'id') ?? [];
                                })
                                ->reactive()
                                ->required()
                                ->columnSpanFull(),

                            Forms\Components\Select::make('parent_id')
                                ->label('Chapter')
                                ->options(function ($get) {
                                    return DocPage::root()
                                        ->where('version_id', $get('version_id'))
                                        ->pluck('title', 'id') ?? [];
                                })
                                ->reactive()
                                ->columnSpanFull(),
                        ])
                        ->collapsed(),

                    Forms\Components\Placeholder::make('created_at')
                        ->label('Created at')
                        ->content(fn () => $this->page->created_at->format('d-m-Y H:i:s'))
                        ->columnSpan(3),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Updated at')
                        ->content(fn () => $this->page->updated_at->format('d-m-Y H:i:s'))
                        ->columnSpan(3),
                ]),
        ];
    }

    public function render()
    {
        return view('livewire.modals.docs.pages.settings');
    }

    public function save()
    {
        DB::beginTransaction();

        $data = $this->form->getState();

        try {
            $this->page->update([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'doc_id' => $data['doc_id'],
                'parent_id' => $data['parent_id'],
                'version_id' => $data['version_id'],
                'project_id' => $data['project_id'],
                'visibility' => $data['visibility'],
            ]);

            DB::commit();

            $this->emit('updatedDoc');
            $this->emit('updatedPage');
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
