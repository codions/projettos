@section('title', $item->title)
@section('image', $item->getOgImage('"' . $item->excerpt .'"', 'Roadmap - Item'))
@section('description', $item->excerpt)

<x-app :breadcrumbs="$project ? [
    ['title' => $project->title, 'url' => route('projects.show', $project)],
    ['title' => $board->title, 'url' => route('projects.boards.show', [$project, $board])],
    ['title' => $item->title, 'url' => route('projects.items.show', [$project, $item])]
]: [
['title' => 'Dashboard', 'url' => route('home')],
['title' => $item->title, 'url' => route('items.show', $item)],
]">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            <x-card>
                <header class="flex items-center px-4 py-2 space-x-4">
                    <div class="flex items-center flex-1 space-x-3 overflow-hidden">
                        @if($user)
                            <div class="relative flex-shrink-0 w-10 h-10 rounded-full">
                                <img class="absolute inset-0 object-cover rounded-full"
                                     src="{{ $user->profile_picture }}"
                                     alt="{{ $user->name }}">
                            </div>
                        @endif

                        <div class="overflow-hidden font-medium">
                            <p>{{ $user->name ?? '-Unknown user-' }}</p>
                        </div>

                        @if($item->board)
                            <div class="flex-1">
                                @if(auth()->check() && auth()->user()->canAccessFilament() && $item->project)
                                    <form method="post"
                                          action="{{ route('projects.items.update-board', [$item->project, $item]) }}">
                                        @csrf
                                        <select name="board_id"
                                                x-data
                                                x-on:change.debounce="$event.target.form.submit()"
                                                class="float-right inline-flex items-center justify-center h-8 px-3 pt-1.5 pr-8 text-sm tracking-tight font-bold text-gray-700 border border-gray-400 rounded-lg bg-white">
                                            @foreach($item->project->boards as $board)
                                                <option value="{{ $board->id }}" @selected($board->is($item->board))>{{ $board->title }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                @else
                                    <span class="float-right inline-flex items-center justify-center h-8 px-3 text-sm tracking-tight font-bold text-gray-700 border border-gray-400 rounded-lg bg-white">
                                        {{ $item->board->title }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </header>

                <div class="border-t"></div>

                <div class="p-4 prose break-words">
                    {!! str($item->content)->markdown()->sanitizeHtml() !!}
                </div>
            </x-card>

            <livewire:item.comments :item="$item"/>
        </div>

        <div class="lg:col-span-1 space-y-4">
            <x-card class="space-y-4">
                <header class="px-2 py-2">
                    @if($item->issue_number && app(App\Services\GitHubService::class)->isEnabled() && app(App\Settings\GeneralSettings::class)->show_github_link)
                        <a href="https://github.com/{{ $item->project->repo }}/issues/{{ $item->issue_number }}" target="_blank">
                            <svg class="text-gray-500 fill-gray-500 float-right ml-2"
                                 width="20" height="20"
                                 x-data
                                 x-tooltip.raw="{{ trans('items.view-on-github') }}"
                                 viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                      d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path>
                            </svg>
                        </a>
                    @endif
                    @if($item->isPinned())
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             x-data
                             x-tooltip.raw="{{ trans('items.item-pinned') }}"
                             class="text-gray-500 fill-gray-500 float-right">
                            <path
                                d="M15 11.586V6h2V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2h2v5.586l-2.707 1.707A.996.996 0 0 0 6 14v2a1 1 0 0 0 1 1h4v3l1 2 1-2v-3h4a1 1 0 0 0 1-1v-2a.996.996 0 0 0-.293-.707L15 11.586z"></path>
                        </svg>
                    @endif
                    @if($item->isPrivate())
                        <span x-data x-tooltip.raw="{{ trans('items.item-private') }}" class="float-right">
                            <x-heroicon-s-lock-closed class="text-gray-500 fill-gray-500 w-5 h-5"/>
                        </span>
                    @endif
                    <h2>{{ $item->title }}</h2>

                    <time class="flex-shrink-0 text-sm font-medium text-gray-500">
                        {{ $item->created_at->isoFormat('L LTS') }}
                    </time>

                    @if(app(\App\Settings\GeneralSettings::class)->enable_item_age)
                        <span class="text-sm font-medium text-gray-500">
                            ({{ $item->created_at->diffInDays(now()) }} {{ trans_choice('items.days-ago', $item->created_at->diffInDays(now())) }})
                        </span>
                    @endif
                </header>

                <div class="border-t"></div>

                <livewire:item.vote-button :model="$item"/>

                @if(auth()->check() && $user && $user->is(auth()->user()))
                    <div class="border-t mb-2"></div>

                    <div>
                        <a class="text-primary-500 hover:text-primary-700 ml-1"
                           href="{{ route('items.edit', $item) }}">Edit item</a>
                    </div>

                @endif

                @if(auth()->check() && auth()->user()->canAccessFilament())
                    <div class="border-t mb-2"></div>

                    <div>
                        <a class="text-red-500 hover:text-red-700 ml-1"
                           href="{{ route('filament.resources.items.edit', $item) }}">Administer item</a>
                    </div>
                @endif

                @if($item->tags->count() > 0)
                    <div class="border-t mb-2"></div>

                    @foreach($item->tags as $tag)
                        <x-tag :tag="$tag"/>
                    @endforeach
                @endif
            </x-card>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 h-full ml-4 border-l border-dashed"></div>
                <x-activities :activities="$activities" />
            </div>
        </div>
    </div>
</x-app>
