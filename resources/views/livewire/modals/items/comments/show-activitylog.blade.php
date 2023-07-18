<x-modal>
    <x-slot name="title">
        <div class="flex justify-between items-center">
            <div>
                {{ trans('comments.activity') }}
            </div>
            <div class="text-medium">
                <button wire:click="$emit('closeModal')">
                    <x-icon-svg name="x" class="h-6 w-6" />
                </button>
            </div>
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="overflow-hidden bg-white shadow rounded-xl">
            <table class="w-full text-left divide-y table-auto">
                <thead>
                    <tr class="divide-x bg-gray-50">
                        <th class="w-1/3 px-4 py-2 text-sm font-semibold text-gray-600">
                            {{ trans('table.updated_at') }}
                        </th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-600">
                            {{ trans('comments.comment') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y whitespace-nowrap">
                    @foreach($comment->activities()->latest()->get() as $activity)
                        <tr class="divide-x">
                            <td class="px-4 py-3">{{ $activity->created_at->isoFormat('L LTS') }}</td>
                            <td class="px-4 py-3 break-words whitespace-pre-line prose">{!! str($activity->changes['old']['content'])->markdown()->sanitizeHtml() !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <x-filament::button color="secondary" wire:click="$emit('closeModal')">
            {{ trans('general.close') }}
        </x-filament::button>
    </x-slot>
</x-modal>
