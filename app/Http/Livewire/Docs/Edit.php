<?php

namespace App\Http\Livewire\Docs;

use App\Models\Doc;
use Carbon\Carbon;
use DB;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public string $locale;

    public Doc $doc;

    public ?string $title;

    public ?string $description;

    protected $listeners = ['save'];

    public function mount()
    {
        $this->fill([
            'title' => $this->doc->title,
            'description' => $this->doc->description,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(6)
                ->schema([
                    RichEditor::make('description')
                        ->columnSpanFull(),
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

        $data = $this->form->getState();

        try {
            $this->doc->update([
                'title' => $this->title,
                'description' => $data['description'],
            ]);

            DB::commit();

            $this->emit('updatedDoc');

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            DB::rollback();
        }
    }

    public function duplicate()
    {
        $new = $this->doc->replicate();
        $new->title = $this->doc->title . ' (Copy)';
        $new->slug = Str::slug($new->title . '-' . Str::random(5));
        $new->created_at = Carbon::now();
        $new->save();

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
