@section('title', trans('tickets.tickets'))

<x-app :breadcrumbs="[
    ['title' => trans('tickets.tickets'), 'url' => route('tickets')]
]">
    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4">
            <div class="space-y-2">
                <div>
                    <h2 class="text-lg tracking-tight font-bold">{{ trans('tickets.created-tickets') }}</h2>
                    <p class="text-gray-500 text-sm">{{ trans('tickets.created-tickets-description') }}</p>
                </div>

                <livewire:tickets.show :ticket="$ticket" />
            </div>
        </div>
    </div>
</x-app>
