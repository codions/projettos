<div class="w-full mx-auto py-5 md:space-x-5 h-full grid grid-cols-6 w-full px-2 sm:px-6 md:px-8 max-w-[1500px]">
    <div class="hidden lg:block w-full">
        <div class="fixed w-full max-w-xs p-8 space-y-8 inset-y-0 left-0 overflow-y-auto transition-transform duration-500 ease-in-out transform lg:col-span-2 lg:w-auto lg:max-w-full lg:ml-8 lg:mr-4 lg:p-0 lg:-translate-x-0 lg:bg-transparent lg:relative lg:overflow-visible -translate-x-full" aria-hidden="false">
            <div  class="space-y-2 -mx-3">
                <div class="py-1">
                    <a href="{{ $doc->edit_url }}" class="group p-1 rounded-md flex gap-4 items-center font-medium lg:text-sm lg:leading-6 text-gray-500 dark:text-gray-300 hover:text-primary-500">
                    <div class="flex items-center justify-center bg-white dark:bg-gray-900 text-primary-600 rounded h-6 w-6 ring-1 ring-gray-900/5 dark:ring-gray-100/5 shadow-sm group-hover:shadow group-hover:ring-gray-900/10 dark:group-hover:ring-gray-100/10 group-hover:shadow-primary-200 dark:group-hover:shadow-primary-800">
                        <x-icon-svg name="document-text" solid class="h-4 w-4" />
                    </div>
                    <span> {{ $doc->title }} </span>
                    </a>
                </div>

                <select wire:model="locale" class="block w-full h-10 dark:bg-gray-800 border-gray-300 dark:border-gray-700 transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500">
                    @foreach($locales as $key => $locale)
                        <option value="{{ $key }}">{{ $locale }}</option>
                    @endforeach
                </select>

                <button wire:click="$emit('openModal', 'modals.docs.versions.manage', {{ json_encode(['doc' => $doc->id, 'currentVersionId' => $version?->id]) }})" class="block w-full py-1 items-center text-gray-800 border border-gray-300 bg-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 text-sm rounded-lg shadow-sm">
                    <span>{{ $version?->title ?? trans('No version created') }}</span>
                </button>
            </div>
            <ul class="space-y-4 -mx-3">
                @foreach($chapters as $chapter)
                @php $isCurrentChapter = (boolean) ($chapter->id === $pageId) @endphp
                <li class="">
                    <li @class([
                        'flex items-center justify-between px-2 py-1 text-gray-900 rounded-md dark:text-white hover:bg-gray-100 group page-item',
                        'bg-gray-100' => $isCurrentChapter,
                    ])>
                        <div class="flex items-center space-x-2">
                            <x-icon-svg name="hashtag" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                            <span wire:click="$emit('loadPage', {{ $chapter->id }})" class="cursor-pointer hover:underline font-bold">{{ $chapter->title }}</span>
                        </div>
                        <x-dropdown>
                            <x-slot name="trigger">
                                <x-icon-svg class="trigger w-4 h-4 text-secondary-500 hover:text-secondary-700 dark:hover:text-secondary-600 transition duration-150 ease-in-out" name="dots-vertical" />
                            </x-slot>
                            <x-dropdown.item wire:click="newPage({{ $chapter->id }})" icon="document-add" :label="__('New subpage')" />
                            <x-dropdown.item icon="cog" :label="__('Settings')" wire:click="$emit('openModal', 'modals.docs.pages.settings', {{ json_encode(['page' => $chapter->id]) }})" />
                            <x-dropdown.item icon="document-duplicate" :label="__('Duplicate')" wire:click="duplicate({{ $chapter->id }})" />
                            <x-dropdown.item icon="trash" :label="__('Delete')" wire:click="$emit('openModal', 'modals.docs.pages.delete', {{ json_encode(['page' => $chapter->id]) }})" />
                        </x-dropdown>
                    </li>
                    <ul class="pl-1 border-l-2 dark:border-gray-600 space-y-2">
                        @foreach($chapter->pages as $item)
                        @php $isCurrentPage = (boolean) ($item->id === $pageId) @endphp
                        <li @class([
                            'flex items-center justify-between px-2 py-1 text-gray-900 rounded-md dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group page-item',
                            'bg-gray-100' => $isCurrentPage,
                        ])>
                            <div class="flex items-center space-x-2">
                                <x-icon-svg name="hashtag" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                                <span wire:click="$emit('loadPage', {{ $item->id }})" class="cursor-pointer hover:underline">{{ $item->title }}</span>
                            </div>
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <x-icon-svg class="trigger w-4 h-4 text-secondary-500 hover:text-secondary-700 dark:hover:text-secondary-600 transition duration-150 ease-in-out" name="dots-vertical" />
                                </x-slot>
                                <x-dropdown.item icon="cog" :label="__('Settings')" wire:click="$emit('openModal', 'modals.docs.pages.settings', {{ json_encode(['page' => $item->id]) }})" />
                                <x-dropdown.item icon="document-duplicate" :label="__('Duplicate')" wire:click="duplicate({{ $item->id }})" />
                                <x-dropdown.item icon="trash" :label="__('Delete')" wire:click="$emit('openModal', 'modals.docs.pages.delete', {{ json_encode(['page' => $item->id]) }})" />
                            </x-dropdown>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
            @if (filled($version))
            <div class="mb-1 flex flex-row -mx-3">
                <button wire:click="newPage" class="flex flex-grow py-2 px-4 items-center gap-3 text-gray-800 border-2 border-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 text-sm rounded-md border">
                  <x-icon-svg name="document-add" class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                  <span>{{ __('New page') }}</span>
                </button>
            </div>
            @endif
        </div>
    </div>

    <main class="flex-1 h-full col-span-6 lg:col-span-5 lg:border-l lg:pl-5 dark:border-gray-700">
        @if(empty($pageId))
            <livewire:docs.edit :doc="$doc" :locale="$locale" :wire:key="'doc-'.$doc->id" />
        @else
            @if(is_null($page))
                {{ trans('The page you are trying to edit could not be found.') }}
            @else
                <livewire:docs.pages.edit :page="$page" :locale="$locale" :wire:key="'page-'.$page->id" />
            @endif
        @endif
    </main>
</div>

@push('javascript')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('page:loaded', () => {
            window.scrollTo(0, 0);
        });
    });
</script>
@endpush
