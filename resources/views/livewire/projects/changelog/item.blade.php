<div class="space-y-4 border rounded-xl p-6">
    <div class="space-y-2">
        <h1 class="font-bold text-2xl hover:text-brand-500">
            <a href="{{ route('projects.changelog.show', [$changelog->project, $changelog]) }}">{{ $changelog->title }}</a>
        </h1>

        @if(app(App\Settings\GeneralSettings::class)->show_changelog_author)
            <div class="flex items-center gap-2">
                <div class="relative w-5 h-5 rounded-full">
                    <img class="absolute inset-0 object-cover rounded-full"
                         src="{{ $changelog->user->profile_picture }}"
                         alt="{{ $changelog->user->name }}">
                </div>
                <span class="text-xs text-gray-500">
                    {{ $changelog->user->name }} {{ trans('notifications.on') }} {{ $changelog->published_at->isoFormat('L') }}
                </span>
            </div>
        @else
            <span class="text-xs text-gray-500">
                {{ $changelog->published_at->isoFormat('L') }}
            </span>
        @endif
    </div>

    <div class="prose break-words">
        {!! str($changelog->content)->markdown() !!}
    </div>

    @if(app(App\Settings\GeneralSettings::class)->show_changelog_related_items && $changelog->items->count())
        <div class="w-full bg-gray-100 rounded-lg p-5">
            <div class="space-y-5">
                @php
                    $items = $changelog->items()
                        ->noChangelogTag()
                        ->get();
                @endphp

                <div>
                    <ul class="list-disc ml-5">
                        @foreach($items as $item)
                            <li>
                                <div>
                                    <a
                                        href="{{ route('items.show', $item) }}"
                                        class="cursor-pointer hover:underline"
                                    >
                                        {{ $item->title }}
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>
