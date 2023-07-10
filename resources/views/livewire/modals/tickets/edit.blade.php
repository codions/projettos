<x-modal>
    <x-slot name="title">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span>{{ trans('tickets.edit') }}</span>
                <span class="bg-gray-100 text-gray-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                    #{{ $ticket->code }}
                </span>
            </div>
            <div class="text-medium">
                <button wire:click="$emit('closeModal')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

    </x-slot>

    <x-slot name="content">
        {{ $this->form }}

        <livewire:tickets.attachments :ticket="$ticket" />
    </x-slot>

    <x-slot name="buttons">
        <x-filament::button wire:click="submit">
            {{ trans('tickets.save') }}
        </x-filament::button>

        <x-filament::button color="secondary" wire:click="$emit('closeModal')">
            {{ trans('general.close') }}
        </x-filament::button>
    </x-slot>
</x-modal>
