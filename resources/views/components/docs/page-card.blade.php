<div class="max-w-sm p-6 border rounded-lg shadow bg-white hover:bg-gray-50 border-gray-200 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
    <div class="flex flex-row">
        <div class="flex items-center w-full">
            <x-dynamic-component :component="$page->project->icon ?? 'heroicon-o-hashtag'"
                class="w-5 h-5 text-gray-500 dark:text-gray-400"/>

            <a href="{{ $page->public_url }}">
                <h5 class="text-lg font-semibold tracking-tight text-gray-900 dark:text-white">{{ $page->title }}</h5>
            </a>
        </div>
    </div>
    @if (!empty($page->description))
    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ str_limit($page->description, 150) }}</p>
    @endif
</div>
