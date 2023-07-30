<x-modal>
    <x-slot name="content">
        <div class="flex items-center">
            <x-icon-svg name="exclamation" class="w-10 h-10 mr-3 text-gray-600 dark:text-gray-300" />
            <div>
                <p class="text-lg font-bold text-gray-600 dark:text-gray-300">{{ trans('Are you sure you want to delete this page?') }}</p>
                <p class="text-md font-semibold text-gray-500 dark:text-gray-300">{{ trans('Deleting this page will also remove all subpages and other related records.') }}</p>
            </div>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <x-filament::button color="secondary" wire:click="$emit('closeModal')">
            {{ trans('No, cancel') }}
        </x-filament::button>

        <x-filament::button type="button" color="danger" wire:click="deleteConfirm">
            {{ trans('Yes, I\'m sure') }}
        </x-filament::button>
    </x-slot>
</x-modal>
