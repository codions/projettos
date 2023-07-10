<header class="sticky top-0 z-10 w-full bg-brand-500 shadow text-white border-b dark:bg-gray-800 dark:border-gray-700"
        x-data="{ open: false }">
    <div class="w-full px-4 mx-auto sm:px-6 md:px-8 max-w-[1500px]">
        <nav class="flex items-center justify-between h-16">
            <a class="text-2xl font-semibold tracking-tight"
               href="{{ route('home') }}">
                @if(!is_null($logo) && file_exists($logoFile = storage_path('app/public/'.$logo)))
                    <img src="{{ asset('storage/'.$logo) }}?v={{ md5_file($logoFile) }}" alt="{{ config('app.name') }}" class="h-9"/>
                @else
                <img src="/images/logos/logo-white.png" alt="{{ config('app.name') }}" class="h-9"/>
                @endif
            </a>

            <ul class="items-center hidden space-x-3 text-sm font-medium text-gray-600 lg:flex">
                <li>
                    <kbd @click="$dispatch('toggle-spotlight')" class="cursor-pointer px-2 py-1.5 text-xs font-semibold text-gray-800 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">{{ trans('general.navbar-search') }}</kbd>
                </li>

                @guest
                <li>
                    <a class="flex items-center justify-center text-white hover:text-gray-50 focus:outline-none"
                    href="{{ route('login') }}">
                        {{ trans('auth.login') }}
                    </a>
                </li>
                <li>
                    <a class="flex items-center justify-center text-white hover:text-gray-50 focus:outline-none"
                    href="{{ route('register') }}">
                        {{ trans('auth.register') }}
                    </a>
                </li>
                @endguest

                <li class="relative">
                    <button x-cloak x-on:click="darkMode = !darkMode;" class="relative block text-white p-2 focus:outline-none" title="{{ _('Toggle dark mode') }}">
                        <svg x-show="darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>

                        <svg x-show="!darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </li>

                @auth
                <li>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <div class="flex items-center space-x-4 cursor-pointer">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->profile_picture }}" alt="{{ auth()->user()->name }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold truncate text-white dark:text-gray-100">
                                        {{ auth()->user()->name }}
                                    </p>
                                    <p class="text-sm truncate text-gray-100 dark:text-gray-200">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>
                            </div>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown.item :href="route('profile')">
                                {{ trans('profile.profile') }}
                            </x-dropdown.item>

                            @if(auth()->user()->hasAdminAccess())
                            <x-dropdown.item :href="route('filament.pages.dashboard')">
                                {{ trans('profile.admin') }}
                            </x-dropdown.item>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown.item :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ trans('profile.logout') }}
                                </x-dropdown.item>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </li>
                @endauth
            </ul>

            <!-- Hamburger -->
            <div class="lg:hidden">
                <button
                    class="text-white flex items-center justify-center w-10 h-10 -mr-2 transition rounded-full focus:outline-none"
                    x-on:click="open = !open"
                    type="button">
                    <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4.75 5.75H19.25"/>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4.75 18.25H19.25"/>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4.75 12H19.25"/>
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile menu -->
        <nav class="-mx-2 lg:hidden"
             x-show="open"
             x-cloak>
            <div class="border-t border-brand-400"></div>

            <ul class="flex flex-col py-2 space-y-1 text-sm font-medium text-white">
                <li>
                    <a class="block p-2 transition rounded-lg focus:outline-none hover:bg-brand-500-400"
                       href="{{ route('home') }}">
                        {{ trans('general.dashboard') }}
                    </a>
                </li>

                <li>
                    <a class="block p-2 transition rounded-lg focus:outline-none hover:bg-brand-500-400"
                       href="{{ route('my') }}">
                        {{ trans('items.my-items') }}
                    </a>
                </li>

                <li>
                    <a class="block p-2 transition rounded-lg focus:outline-none hover:bg-brand-500-400"
                       href="{{ route('support') }}">
                        {{ trans('support.support') }}
                    </a>
                </li>

                <li>
                    <a class="block p-2 transition rounded-lg focus:outline-none hover:bg-brand-500-400"
                       href="{{ route('projects.index') }}">
                        {{ trans('projects.projects') }}
                    </a>
                </li>

                <li>
                    <a class="block p-2 transition rounded-lg focus:outline-none hover:bg-brand-500-400"
                       href="{{ route('profile') }}">
                        {{ trans('auth.profile') }}
                    </a>
                </li>
            </ul>
        </nav>

        @if($pinnedProjects->count())
        <nav class="-mx-2 lg:hidden"
             x-show="open"
             x-cloak>

            <ul class="flex flex-col py-2 space-y-1 text-sm font-medium text-white">
                @foreach($pinnedProjects as $project)
                    <li>
                        <a class="block p-2 transition rounded-lg focus:outline-none hover:bg-brand-500-400"
                           href="{{ route('projects.show', $project) }}">
                            {{ $project->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
        @endif
    </div>
</header>
