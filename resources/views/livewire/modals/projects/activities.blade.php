<x-modal>
    <x-slot name="title">
        <div class="flex justify-between items-center">
            <div>
                {{ trans('projects.activities') }}
            </div>
            <div class="text-medium">
                <button wire:click="$emit('closeModal')">
                    <x-icon-svg name="x" class="h-6 w-6" />
                </button>
            </div>
        </div>

    </x-slot>

    <x-slot name="content">
        <x-activities :activities="$this->getActivities()" />
    </x-slot>
</x-modal>
