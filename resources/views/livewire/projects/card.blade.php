<div class="max-w-sm p-6 border rounded-lg shadow bg-white hover:bg-gray-50 border-gray-200">
    <x-dynamic-component :component="$project->icon ?? 'heroicon-o-hashtag'"
        class="w-7 h-7 text-gray-500 dark:text-gray-400 mb-3"/>

    <a href="{{ route('projects.show', $project) }}">
        <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $project->title }}</h5>
    </a>
    @if (!empty($project->description))
    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">{{ str_limit($project->description, 150) }}</p>
    @endif
</div>
