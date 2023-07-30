<?php

namespace App\Http\Livewire\Modals\Docs\Pages;

use App\Models\DocPage;
use Filament\Http\Livewire\Concerns\CanNotify;
use LivewireUI\Modal\ModalComponent;

class Delete extends ModalComponent
{
    use CanNotify;

    public DocPage $page;

    public function render()
    {
        return view('livewire.modals.docs.pages.delete');
    }

    public function deleteConfirm()
    {
        if (! $this->page->canBeDeleted()) {
            return $this->notify('danger', trans('You can only delete your own docs.'));
        }

        if ($this->page->delete()) {
            $this->notify('success', trans('Page deleted successfully!'));

            $this->emit('page:deleted', $this->page->id);
        }

        $this->closeModal();
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }
}
