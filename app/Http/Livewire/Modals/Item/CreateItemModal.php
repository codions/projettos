<?php

namespace App\Http\Livewire\Modals\Item;

use function app;
use App\Enums\UserRole;
use App\Filament\Resources\ItemResource;
use App\Filament\Resources\UserResource;
use App\Models\Item;
use App\Models\Project;
use App\Models\Board;
use App\Models\User;
use App\Rules\ProfanityCheck;
use App\Settings\GeneralSettings;
use function auth;
use Closure;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Http\Livewire\Concerns\CanNotify;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use LivewireUI\Modal\ModalComponent;
use function redirect;
use function route;
use function view;

class CreateItemModal extends ModalComponent implements HasForms
{
    use InteractsWithForms;
    use CanNotify;

    public $similarItems;

    public ?Project $project = null;

    public ?Board $board = null;

    public array $state = [
        'project_id' => null,
        'board_id' => null,
    ];

    public function mount()
    {
        $this->form->fill([]);
        $this->similarItems = collect([]);
    }

    public function hydrate()
    {
        $this->setSimilarItems($this->state['title']);
    }

    protected function getFormSchema(): array
    {
        $inputs = [];

        if (is_null($this->project?->id) && app(GeneralSettings::class)->select_project_when_creating_item) {
            $inputs[] = Select::make('state.project_id')
                ->label(trans('table.project'))
                ->reactive()
                ->options(Project::query()->visibleForCurrentUser()->pluck('title', 'id'))
                ->required(app(GeneralSettings::class)->project_required_when_creating_item);
        }

        if (is_null($this->board?->id) && app(GeneralSettings::class)->select_board_when_creating_item) {
            $inputs[] = Select::make('state.board_id')
                ->label(trans('table.board'))
                ->visible(fn ($get) => $this->project?->id ?? $get('state.project_id'))
                ->options(function ($get) {
                    if ($this->project?->id) {
                        return $this->project->boards->pluck('title', 'id');
                    } else {
                        return Project::find($get('state.project_id'))->boards()->pluck('title', 'id');
                    }
                })
                ->required(app(GeneralSettings::class)->board_required_when_creating_item);
        }

        $inputs[] = TextInput::make('state.title')
            ->autofocus()
            ->rules([
                new ProfanityCheck(),
            ])
            ->label(trans('table.title'))
            ->lazy()
            ->afterStateUpdated(function (Closure $set, $state) {
                $this->setSimilarItems($state);
            })
            ->minLength(3)
            ->required();

        $inputs[] = Group::make([
            MarkdownEditor::make('state.content')
                ->label(trans('table.content'))
                ->rules([
                    new ProfanityCheck(),
                ])
                ->disableToolbarButtons(app(GeneralSettings::class)->getDisabledToolbarButtons())
                ->minLength(10)
                ->required(),
        ]);

        return $inputs;
    }

    public function submit()
    {
        if (! auth()->user()) {
            return redirect()->route('login');
        }

        if (app(GeneralSettings::class)->users_must_verify_email && ! auth()->user()->hasVerifiedEmail()) {
            $this->notify('primary', 'Please verify your email before submitting items.');

            return redirect()->route('verification.notice');
        }

        $data = $this->form->getState()['state'];

        $projectId = $this->project?->id ?? $data['project_id'];
        $boardId = $this->board?->id ?? $data['board_id'];

        $item = Item::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'project_id' => $projectId,
            'board_id' => $boardId,
        ]);

        $item->user()->associate(auth()->user())->save();

        $item->toggleUpvote();

        $this->closeModal();

        $this->notify('success', trans('items.item_created'));

        if (config('filament.database_notifications.enabled')) {
            User::query()->whereIn('role', [UserRole::Admin->value, UserRole::Employee->value])->each(function (User $user) use ($item) {
                Notification::make()
                    ->title(trans('items.item_created'))
                    ->body(trans('items.item_created_notification_body', ['user' => auth()->user()->name, 'title' => $item->title]))
                    ->actions([
                        Action::make('view')->label(trans('notifications.view-item'))->url(ItemResource::getUrl('edit', ['record' => $item])),
                        Action::make('view_user')->label(trans('notifications.view-user'))->url(UserResource::getUrl('edit', ['record' => auth()->user()])),
                    ])
                    ->sendToDatabase($user);
            });
        }

        return redirect()->route('items.show', $item->slug);
    }

    public function setSimilarItems($state): void
    {
        // TODO:
        // At some point we're going to want to exclude (filter from the array) common words (that should probably be configurable by the user)
        // or having those common words inside the translation file, preference is to use the settings plugin
        // we already have, so that the administrators can put in common words.
        //
        // Common words example: the, it, that, when, how, this, true, false, is, not, well, with, use, enable, of, for
        // ^ These are words you don't want to search on in your database and exclude from the array.
        $words = collect(explode(' ', $state))->filter(function ($item) {
            $excludedWords = app(GeneralSettings::class)->excluded_matching_search_words;

            return ! in_array($item, $excludedWords);
        });

        $this->similarItems = $state ? Item::query()
            ->visibleForCurrentUser()
            ->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->orWhere('title', 'like', '%' . $word . '%');
                }

                return $query;
            })->get(['title', 'slug']) : collect([]);
    }

    public function render()
    {
        return view('livewire.modals.items.create');
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
