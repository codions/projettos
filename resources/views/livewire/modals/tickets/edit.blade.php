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
                    <x-icon-svg name="x" class="h-6 w-6" />
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
