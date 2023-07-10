@section('title', trans('projects.projects'))

<x-app :breadcrumbs="[
    ['title' => trans('projects.projects'), 'url' => route('projects.index')]
]">
    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4">
            <livewire:projects.index />
        </div>
    </div>
</x-app>
