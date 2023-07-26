<x-modal>
    <x-slot name="title">
        <div class="flex justify-between items-center">
            <div>
                {{ trans('Page settings') }}

                <div class="flex flex-row items-center space-x-1">
                    <h5 class="text-sm font-medium text-gray-900 dark:text-white">{{ $page->title }}</h5>
                </div>
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
    </x-slot>

    <x-slot name="buttons">
        <x-filament::button wire:click="save">
            {{ trans('general.save') }}
        </x-filament::button>

        <x-filament::button color="secondary" wire:click="$emit('closeModal')">
            {{ trans('general.close') }}
        </x-filament::button>
    </x-slot>
</x-modal>
