<x-modal>
    <x-slot name="title">
        <div class="flex justify-between items-center">
            <div>
                {{ trans('comments.edit-comment') }}
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
        <x-filament::button wire:click="submit">
            {{ trans('general.save') }}
        </x-filament::button>

        <x-filament::button color="secondary" wire:click="$emit('closeModal')">
            {{ trans('general.close') }}
        </x-filament::button>
    </x-slot>
</x-modal>
