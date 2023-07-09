@section('title', trans('support.support'))

<x-app :breadcrumbs="[
    ['title' => trans('support.support'), 'url' => route('support')]
]">
    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4">
            <livewire:tickets.index />
        </div>
    </div>
</x-app>
