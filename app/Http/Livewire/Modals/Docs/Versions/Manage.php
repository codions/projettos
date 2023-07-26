<?php

namespace App\Http\Livewire\Modals\Docs\Versions;

use App\Models\Doc;
use Filament\Http\Livewire\Concerns\CanNotify;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use LivewireUI\Modal\ModalComponent;

class Manage extends ModalComponent
{
    use CanNotify;

    public Doc $doc;

    public $state = [
        'id' => null,
        'title' => null,
        'slug' => null,
    ];

    public $versionId;

    protected $listeners = [
        'version:loaded' => 'closeModal',
    ];

    protected $queryString = [
        'versionId',
    ];

    public $idForDeletion = null;

    public $displayForm = false;

    public function getVersions()
    {
        return $this->doc->versions()->latest()->get();
    }

    public function render()
    {
        return view('livewire.modals.docs.versions.manage');
    }

    public function save()
    {
        $rules = [
            'state.title' => 'required|min:2|max:50',
            'state.slug' => [
                'required',
                'regex:/^[a-z0-9_.-]+$/',
            ],
        ];

        if (filled($this->state['id'])) {
            return $this->updateVersion($rules);
        }

        return $this->saveVersion($rules);
    }

    private function saveVersion(array $rules)
    {
        $rules['state.slug'][] = Rule::unique('doc_versions', 'slug')
            ->where(fn (Builder $query) => $query->where('doc_id', $this->doc->id));

        $data = $this->validate($rules);

        $this->doc->versions()->create($data['state']);

        $this->emit('version:updated');

        $this->toggleForm();
    }

    private function updateVersion(array $rules)
    {
        $rules['state.slug'][] = Rule::unique('doc_versions', 'slug')
            ->ignore($this->state['id'])
            ->where(fn (Builder $query) => $query->where('doc_id', $this->doc->id));

        $data = $this->validate($rules);

        $version = $this->doc->versions()->find($this->state['id']);

        $version->update($data['state']);

        $this->emit('version:updated');

        $this->toggleForm();
    }

    public function editVersion($id)
    {
        $this->reset('state');

        $version = $this->doc->versions()->findOrFail($id);

        $this->state = [
            'id' => $version->id,
            'title' => $version->title,
            'slug' => $version->slug,
        ];

        $this->displayForm = true;
    }

    public function deleteVersion($id)
    {
        $version = $this->doc->versions()->find($id);

        $version->delete();
        $this->idForDeletion = null;

        $this->notify('success', trans('Successfully deleted version'));

        $this->emit('version:deleted', $id);
    }

    public function duplicateVersion($id)
    {
        $version = $this->doc->versions()->find($id);
        $version->duplicateWithPages();
    }

    public function updatedStateTitle()
    {
        if (! filled($this->state['id'])) {
            $this->state['slug'] = Str::slug($this->state['title']);
        }
    }

    public function toggleForm()
    {
        $this->reset('state');
        $this->displayForm = ! $this->displayForm;
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
