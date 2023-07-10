<div class="max-w-sm p-6 border rounded-lg shadow bg-white hover:bg-gray-50 border-gray-200 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
    <x-dynamic-component :component="$project->icon ?? 'heroicon-o-hashtag'"
        class="w-7 h-7 text-gray-500 dark:text-gray-400 mb-3"/>

    <div class="flex flex-row">
        <div class="flex items-center w-full">
        <a href="{{ route('projects.show', $project) }}">
            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $project->title }}</h5>
        </a>
        </div>
        <div class="flex items-center space-x-2">
            @if($project->private)
                <div title="{{ __('Private') }}" class="inline-block text-gray-500 dark:text-gray-400">
                    <x-heroicon-o-lock-closed class="w-4 h-4" />
                </div>
            @endif
            @if($project->pinned)
                <div title="{{ __('Pinned') }}" class="inline-block text-gray-500 dark:text-gray-400">
                    <x-heroicon-o-bookmark class="w-4 h-4" />
                </div>
            @endif
        </div>
    </div>
    @if (!empty($project->description))
    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ str_limit($project->description, 150) }}</p>
    @endif
</div>
