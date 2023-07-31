<?php

namespace App\Http\Livewire\Docs\Pages;

use App\Models\DocPage;
use DB;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Notifications\Notification;
use Livewire\Component;

class Edit extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $locale;

    public DocPage $page;

    public ?string $title;

    public ?string $content;

    protected $listeners = [
        'save',
        'updatedPage' => '$refresh',
    ];

    public function mount()
    {
        $this->fill([
            'title' => $this->page->title,
            'content' => $this->page->content,
        ]);
    }

    public function save()
    {
        DB::beginTransaction();

        $data = $this->form->getState();

        try {
            $this->page->update([
                'title' => $this->title,
                'content' => $data['content'],
            ]);

            DB::commit();

            $this->emit('updatedDoc');
            $this->emit('updatedPage');

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            DB::rollback();
        }
    }

    public function duplicate()
    {
        $new = $this->page->duplicateWithSubpages();

        return redirect()->to($new->edit_url);
    }

    public function delete()
    {
        if (! $this->page->canBeDeleted()) {
            return Notification::make()
                ->title(__('Request failed'))
                ->body(__('You can only delete your own docs.'))
                ->danger()
                ->send();
        }

        $doc = $this->page->doc;
        $this->page->delete();

        return redirect()->to($doc->edit_url);
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(6)
                ->schema([
                    RichEditor::make('content')
                        ->columnSpanFull(),
                ]),
        ];
    }

    public function render()
    {
        return view('livewire.docs.pages.edit');
    }
}
