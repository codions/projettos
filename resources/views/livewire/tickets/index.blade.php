@section('title', trans('support.support'))

<div class="space-y-2">

    <div class="max-w-full mx-auto">
        <div class="lg:flex lg:items-center lg:justify-between">
          <div class="flex-1 min-w-0">
              <h2 class="text-lg tracking-tight font-bold">{{ trans('tickets.created-tickets') }}</h2>
              <p class="text-gray-500 text-sm">{{ trans('tickets.created-tickets-description') }}</p>
          </div>
          <div class="mt-5 flex lg:mt-0 lg:ml-4">
              <x-filament::button color="secondary" wire:click="$emit('openModal', 'modals.tickets.create')">
                  {{ trans('tickets.new-ticket') }}
              </x-filament::button>
          </div>
        </div>
      </div>

    {{ $this->table }}
</div>
