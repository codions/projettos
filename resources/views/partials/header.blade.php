<header class="sticky top-0 z-10 w-full bg-brand-500 shadow text-white"
        x-data="{ open: false }">
    <div class="w-full px-4 mx-auto sm:px-6 md:px-8 max-w-[1500px]">
        <nav class="flex items-center justify-between h-20">
            <a class="text-2xl font-semibold tracking-tight"
               href="{{ route('home') }}">
                @if(!is_null($logo) && file_exists($logoFile = storage_path('app/public/'.$logo)))
                    <img src="{{ asset('storage/'.$logo) }}?v={{ md5_file($logoFile) }}" alt="{{ config('app.name') }}" class="h-10"/>
                @else
                <img src="/images/logos/logo-white.png" alt="{{ config('app.name') }}" class="h-10"/>
                @endif
            </a>

            <ul class="items-center hidden space-x-3 text-sm font-medium text-gray-600 lg:flex">
                <li>
                    <kbd @click="$dispatch('toggle-spotlight')" class="cursor-pointer p-1 items-center shadow justify-center rounded border border-gray-400 hover:bg-gray-200 bg-white font-semibold text-gray-900">{{ trans('general.navbar-search') }}</kbd>
                </li>
                <li>
                    <x-filament::button color="secondary" onclick="Livewire.emit('openModal', 'modals.item.create-item-modal')"
                                        icon="heroicon-o-plus-circle">
                        {{ trans('items.create') }}
                    </x-filament::button>
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
                            <x-dropdown-link :href="route('profile')">
                                {{ trans('profile.profile') }}
                            </x-dropdown-link>

                            @if(auth()->user()->hasAdminAccess())
                            <x-dropdown-link :href="route('filament.pages.dashboard')">
                                {{ trans('profile.admin') }}
                            </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ trans('profile.logout') }}
                                </x-dropdown-link>
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
                       href="{{ route('profile') }}">
                        {{ trans('auth.profile') }}
                    </a>
                </li>
                <li>
                    <x-filament::button color="secondary" onclick="Livewire.emit('openModal', 'modals.item.create-item-modal')"
                                        icon="heroicon-o-plus-circle">
                        {{ trans('items.create') }}
                    </x-filament::button>
                </li>
            </ul>
        </nav>

        <nav class="-mx-2 lg:hidden"
             x-show="open"
             x-cloak>

            <ul class="flex flex-col py-2 space-y-1 text-sm font-medium text-white">
                @foreach($projects as $project)
                    <li>
                        <a class="block p-2 transition rounded-lg focus:outline-none hover:bg-brand-500-400"
                           href="{{ route('projects.show', $project) }}">
                            {{ $project->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>
