<?php

namespace App\Http\Livewire\Modals\Item\Comment;

use App\Models\Comment;
use App\Settings\GeneralSettings;
use function auth;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Http\Livewire\Concerns\CanNotify;
use LivewireUI\Modal\ModalComponent;
use function redirect;
use function view;

class EditCommentModal extends ModalComponent implements HasForms
{
    use InteractsWithForms;
    use CanNotify;

    public $comment;

    public function mount(Comment $comment)
    {
        abort_if($comment->user->isNot(auth()->user()), 403);

        $this->comment = $comment;
    }

    protected function getFormSchema(): array
    {
        return [
            Group::make([
                MarkdownEditor::make('content')
                    ->label(trans('comments.comment'))
                    ->id('edit-comment' . $this->comment->id)
                    ->disableToolbarButtons(app(GeneralSettings::class)->getDisabledToolbarButtons())
                    ->required(),
            ]),
        ];
    }

    public function submit()
    {
        if (! auth()->user()) {
            return redirect()->route('login');
        }

        $this->comment->update($this->form->getState());

        $this->closeModal();

        $this->notify('success', trans('comments.comment-updated'));

        $this->emit('updatedComment');
    }

    public function render()
    {
        $this->form->fill([
            'content' => $this->comment->content,
        ]);

        return view('livewire.modals.items.comments.edit');
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
