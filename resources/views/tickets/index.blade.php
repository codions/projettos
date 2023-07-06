@section('title', trans('tickets.tickets'))

<x-app :breadcrumbs="[
    ['title' => trans('tickets.tickets'), 'url' => route('tickets')]
]">
    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4">
            <div class="space-y-2">

                <div class="max-w-full mx-auto">
                  <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-lg tracking-tight font-bold">{{ trans('tickets.created-tickets') }}</h2>
                        <p class="text-gray-500 text-sm">{{ trans('tickets.created-tickets-description') }}</p>
                    </div>
                    <div class="mt-5 flex lg:mt-0 lg:ml-4">
                        <x-filament::button color="secondary" onclick="Livewire.emit('openModal', 'modals.ticket.create-ticket-modal')"
                                            icon="heroicon-o-ticket">
                            {{ trans('tickets.new-ticket') }}
                        </x-filament::button>
                    </div>
                  </div>
                </div>

                <livewire:tickets.index />
            </div>
        </div>
    </div>
</x-app>
