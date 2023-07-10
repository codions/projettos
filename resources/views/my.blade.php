@section('title', trans('items.my-items'))

<x-layouts.app :breadcrumbs="[
    ['title' => trans('items.my-items'), 'url' => route('my')]
]">
    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4">
            <div class="space-y-2">
                <div>
                    <h2 class="text-lg tracking-tight font-bold">{{ trans('items.created-items') }}</h2>
                    <p class="text-gray-500 text-sm">{{ trans('items.created-items-description') }}</p>
                </div>
                <livewire:my />
            </div>
            <div class="space-y-2">
                <div>
                    <h2 class="text-lg tracking-tight font-bold">{{ trans('items.voted-items') }}</h2>
                    <p class="text-gray-500 text-sm">{{ trans('items.voted-items-description') }}</p>
                </div>
                <livewire:my type="voted" />
            </div>
            <div class="space-y-2">
                <div>
                    <h2 class="text-lg tracking-tight font-bold">{{ trans('items.recent-mentions') }}</h2>
                    <p class="text-gray-500 text-sm">{{ trans('items.recent-mentions-description') }}</p>
                </div>
                <livewire:recent-mentions />
            </div>

            <div class="space-y-2">
                <div>
                    <h2 class="text-lg tracking-tight font-bold">{{ trans('items.commented-items') }}</h2>
                    <p class="text-gray-500 text-sm">{{ trans('items.commented-items-description') }}</p>
                </div>
                <livewire:my type="commentedOn" />
            </div>
        </div>
    </div>
</x-layouts.app>
