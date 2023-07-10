<x-layouts.base>

<div class="w-full mx-auto py-5 md:space-x-10 h-full grid grid-cols-6 w-full px-2 sm:px-6 md:px-8 max-w-[1500px]">
    @include('partials.navbar')

    <main class="flex-1 h-full col-span-6 lg:col-span-5 lg:border-l lg:pl-5 dark:border-gray-700">
        <div class="pb-4">
            <ul class="flex items-center space-x-0.5 text-sm font-medium text-gray-600 dark:text-gray-300">
                @foreach($breadcrumbs as $breadcrumb)
                    @if(!$loop->first)
                        <li>
                            <svg class="text-gray-400 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="1.5" d="M10.75 8.75L14.25 12L10.75 15.25"/>
                            </svg>
                        </li>
                    @endif

                    <li>
                        <a class="transition hover:underline focus:outline-none focus:text-gray-800 focus:underline"
                           href="{{ $breadcrumb['url'] }}">
                            {{ $breadcrumb['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{ $slot }}
    </main>
</div>

</x-layouts.base>
