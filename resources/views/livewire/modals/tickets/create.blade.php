<x-modal>
    <x-slot name="title">
        <div class="flex justify-between items-center">
            <div>
                {{ trans('tickets.create') }}
                @if ($project?->title)
                <div class="flex flex-row items-center space-x-1">
                    <h5 class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->title }}</h5>
                </div>
                @endif
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
    </x-slot>

    <x-slot name="buttons">
        <x-filament::button wire:click="submit">
            {{ trans('tickets.create') }}
        </x-filament::button>

        <x-filament::button color="secondary" wire:click="$emit('closeModal')">
            {{ trans('general.close') }}
        </x-filament::button>
    </x-slot>
</x-modal>
