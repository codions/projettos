<x-modal>
    <x-slot name="content">
        <div>{!! trans('tickets.confirm-ticket-status-change', ['status' => $status]) !!}</div>
        @error('status') <span class="font-semibold text-red-500">{{ $message }}</span> @enderror
    </x-slot>

    <x-slot name="buttons">
        <x-filament::button wire:click="submit">
            {{ trans('general.confirm') }}
        </x-filament::button>

        <x-filament::button color="secondary" wire:click="$emit('closeModal')">
            {{ trans('general.cancel') }}
        </x-filament::button>
    </x-slot>
</x-modal>
