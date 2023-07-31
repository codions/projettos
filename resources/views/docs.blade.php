<x-layouts.base>
    <div class="w-full mx-auto py-5 md:space-x-5 h-full grid grid-cols-6 w-full px-2 sm:px-6 md:px-8 max-w-[1500px]">
        <div class="hidden lg:block w-full">
            <div class="fixed w-full max-w-xs p-8 space-y-8 inset-y-0 left-0 overflow-y-auto transition-transform duration-500 ease-in-out transform lg:col-span-2 lg:w-auto lg:max-w-full lg:ml-8 lg:mr-4 lg:p-0 lg:-translate-x-0 lg:bg-transparent lg:relative lg:overflow-visible -translate-x-full" aria-hidden="false">
                <div
                x-data="{
                    locale: '{{ $locale }}',
                    version: '{{ $version?->slug }}'
                }"
                x-init="
                    $watch('locale', () => window.location = `/docs/{{ $doc->slug }}/${locale}`);
                    $watch('version', () => window.location = `/docs/{{ $doc->slug }}/${locale}/${version}`);
                "
                class="space-y-2 -mx-3">
                    <div class="py-1">
                        <a href="{{ $doc->public_url }}" class="group p-1 rounded-md flex gap-4 items-center font-medium lg:text-sm lg:leading-6 text-gray-500 dark:text-gray-300 hover:text-primary-500">
                        <div class="flex items-center justify-center bg-white dark:bg-gray-900 text-primary-600 rounded h-6 w-6 ring-1 ring-gray-900/5 dark:ring-gray-100/5 shadow-sm group-hover:shadow group-hover:ring-gray-900/10 dark:group-hover:ring-gray-100/10 group-hover:shadow-primary-200 dark:group-hover:shadow-primary-800">
                            <x-icon-svg name="document-text" solid class="h-4 w-4" />
                        </div>
                        <span> {{ $doc->title }} </span>
                        </a>
                    </div>

                    <select x-model="locale" class="block w-full h-10 dark:bg-gray-800 border-gray-300 dark:border-gray-700 transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500">
                        @foreach($locales as $key => $locale)
                            <option value="{{ $key }}">{{ $locale }}</option>
                        @endforeach
                    </select>

                    <select x-model="version" class="block w-full h-10 dark:bg-gray-800 border-gray-300 dark:border-gray-700 transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500">
                        @foreach ($doc->versions as $version)
                            <option value="{{ $version->slug }}">
                                {{ $version->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <ul class="space-y-4">
                    @foreach ($chapters as $chapter)
                        @php
                            $isActive = false;
                        @endphp

                        <li class="space-y-1">
                            <a
                                href="{{ $chapter->public_url }}"
                                @class([
                                    'font-medium transition hover:text-primary-600 dark:hover:text-primary-400 focus:text-primary-600 dark:focus:text-primary-400',
                                    'text-gray-900 dark:text-gray-300' => ! $isActive,
                                    'text-primary-600 dark:text-primary-500' => $isActive,
                                ])
                            >
                                {{ $chapter->title }}
                            </a>

                            <ul class="pl-4 border-l-2 dark:border-gray-600 space-y-2">
                                @foreach ($chapter->pages as $item)
                                @php $isActive = false; @endphp
                                <li class="relative leading-5">
                                    @if ($isActive)
                                        <div class="absolute left-0 top-2 -ml-[1.2rem] h-1 w-1 bg-primary-600 rounded-full"></div>
                                    @endif

                                    <a
                                        href="{{ $item->public_url }}"
                                        @class([
                                            'text-sm transition hover:text-primary-600 dark:hover:text-primary-400 focus:text-primary-600 dark:focus:text-primary-400',
                                            'text-gray-700 dark:text-gray-400' => ! $isActive,
                                            'text-primary-600 dark:text-primary-500 font-medium' => $isActive,
                                        ])
                                    >
                                        {{ $item->title }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <main class="flex-1 h-full col-span-6 lg:col-span-5 lg:border-l lg:pl-5 dark:border-gray-700">
            @if(filled($page))
            @php $hasSubpages = $page->pages()->count(); @endphp
                <div class="mx-auto prose dark:prose-invert max-w-none">
                    <h1 class="font-heading">
                        {{ $page->title }}
                    </h1>

                    @if (filled($page->section))
                        <div class="-mt-6 mb-8 text-xl font-medium">
                            {{ $page->section }}
                        </div>
                    @endif

                    @if($hasSubpages)
                        <div class="grid 2xl:grid-cols-3 xl:grid-cols-3 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-5">
                            @foreach ($page->pages as $subpage)
                                <x-docs.page-card :page="$subpage" />
                            @endforeach
                        </div>
                    @endif

                    @if(filled($page->content))
                        {!! $page->content !!}
                    @else
                        @if (!$hasSubpages)
                            <div class="border p-6 rounded-xl flex items-center justify-center">
                                <p class="text-md text-gray-500 m-4">{{ trans('Oops! It looks like this page is still blank.') }}</p>
                            </div>
                        @endif
                    @endif
                </div>

                <x-filament-support::link :href="$page->edit_url" class="mt-3">
                    {{trans('Edit')}}
                </x-filament-support::link>
            @else

            @endif
        </main>
    </div>

</x-layouts.base>
