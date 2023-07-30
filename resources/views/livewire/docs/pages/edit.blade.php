<div class="flex flex-col w-full bg-white rounded-xl border border-gray-300 dark:bg-gray-800 dark:border-gray-700">

    <div class="flex items-center align-middle justify-between px-5 border-b border-slate-200 dark:border-gray-700">
        <div class="flex items-center py-3 w-11/12">
            <a href="{{ route('docs.index') }}">
                <x-icon-svg name="arrow-left" class="text-gray-600 mr-3 w-6 h-6" />
            </a>
            <div class="flex flex-col w-full mr-2">
                <input type="text" class="text-gray-500 font-bold text-md border rounded-md border-gray-100 hover:border hover:rounded-md hover:border-gray-300 hover:shadow-sm" wire:model="title" placeholder="{{ __('Type a title for the document') }}">
            </div>
        </div>
        <div class="float-right">
            <div class='flex items-center justify-center'>
                <x-button wire:click="save" md primary :label="__('Save')" class="mr-1" />
                <x-dropdown>
                    <x-dropdown.item icon="cog" :label="__('Settings')" wire:click="$emit('openModal', 'modals.docs.pages.settings', {{ json_encode(['page' => $page->id]) }})" />
                    <x-dropdown.item separator icon="link" :label="__('URL')" target="_blank" :href="$page->public_url" />
                    <x-dropdown.item separator icon="document-duplicate" :label="__('Duplicate')" wire:click="duplicate" />
                    <x-dropdown.item separator icon="trash" :label="__('Delete')" wire:click="$emit('openModal', 'modals.docs.pages.delete', {{ json_encode(['page' => $page->id]) }})" />
                </x-dropdown>
            </div>
        </div>
    </div>

    <div class="px-2 pb-2 editor-panel">

        <div class="flex items-center py-2">
            <a href="{{ $page->public_url }}" target="_blank">
                <x-icon-svg name="external-link" solid class="h-4 w-4 text-gray-500 dark:text-gray-300 mr-1" />
            </a>
            <button wire:click="$emit('openModal', 'modals.docs.pages.settings', {{ json_encode(['page' => $page->id]) }})" class="text-gray-400 dark:text-gray-500 hover:underline">
                {{ $page->public_url }}
            </button>
        </div>

        {{ $this->form }}
    </div>
</div>
