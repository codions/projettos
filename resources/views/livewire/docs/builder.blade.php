<div class="w-full mx-auto py-5 md:space-x-10 h-full grid grid-cols-6 w-full px-2 sm:px-6 md:px-8 max-w-[1500px]">
    <div class="hidden lg:block">
        <aside class="w-60" aria-label="Sidebar">
            <div class="space-y-4">
                <aside class="fixed w-full max-w-xs p-8 space-y-8 inset-y-0 left-0 overflow-y-auto transition-transform duration-500 ease-in-out transform lg:col-span-2 lg:w-auto lg:max-w-full lg:ml-8 lg:mr-4 lg:p-0 lg:-translate-x-0 lg:bg-transparent lg:relative lg:overflow-visible -translate-x-full" aria-hidden="false">
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

                        <select wire:model="versionId" class="block w-full h-10 dark:bg-gray-800 border-gray-300 dark:border-gray-700 transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500">
                            @foreach($versions as $version)
                                <option value="{{ $version->id }}">{{ $version->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <ul class="space-y-4">
                        @foreach($chapters as $chapter)
                        <li class="space-y-1">
                            <button wire:click="$emit('loadPage', {{ $chapter->id }})" class="font-medium transition hover:text-primary-600 dark:hover:text-primary-400 focus:text-primary-600 dark:focus:text-primary-400 text-primary-600 dark:text-primary-500">{{ $chapter->title }}</button>
                            <ul class="pl-4 border-l-2 dark:border-gray-600 space-y-2">
                                @foreach($chapter->pages as $item)
                                {{-- <li class="relative leading-5">
                                    <button wire:click="$emit('loadPage', {{ $item->id }})" class="text-sm transition hover:text-primary-600 dark:hover:text-primary-400 focus:text-primary-600 dark:focus:text-primary-400 text-gray-700 dark:text-gray-400">{{ $item->title }}</button>
                                </li> --}}
                                <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                                    <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                                    <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                                </svg>
                                <span class="ml-3">Dashboard</span>
                                </a>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </aside>
            </div>
        </aside>
    </div>

    <main class="flex-1 h-full col-span-6 lg:col-span-5 lg:border-l lg:pl-5 dark:border-gray-700">

        @if(empty($pageId))
            <livewire:docs.edit :doc="$doc" :locale="$locale" :wire:key="'doc-'.$doc->id" />
        @else
            <livewire:docs.pages.edit :page="$page" :locale="$locale" :wire:key="'page-'.$page->id" />
        @endif
    </main>
</div>
