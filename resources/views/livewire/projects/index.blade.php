@section('title', trans('projects.projects'))

<div class="2xl:container xl:container lg:container mx-auto">

    @php
        $projects = $this->getProjects();
    @endphp

<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <div class="flex items-center gap-x-3">
            <h2 class="text-lg font-bold text-gray-800 dark:text-white">{{ __('Explore Projects') }}</h2>
            <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ $projects->total() }}</span>
        </div>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">{{ __('Submit suggestions, track boards, create tickets and consult documentation.') }}</p>
    </div>
</div>

@if($this->showFilters())
<div class="mt-6 md:flex md:items-center md:justify-between">
    <div class="md:flex md:items-center space-x-4">
        @if(auth()->check() && auth()->user()->hasAdminAccess())
        <div>
            <button wire:click="resetFilters" class="w-full px-5 py-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                <span class="text-sm font-medium">{{ __('All') }}</span>
            </button>
        </div>
        <div>
            <input type="checkbox" id="private-option" wire:model="filter.private" value="1" class="hidden peer">
            <label for="private-option" class="inline-flex items-center justify-between w-full px-5 py-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                <span class="text-sm font-medium">{{ __('Private') }}</span>
            </label>
        </div>
        <div>
            <input type="checkbox" id="pinned-option" wire:model="filter.pinned" value="1" class="hidden peer">
            <label for="pinned-option" class="inline-flex items-center justify-between w-full px-5 py-2 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                  </svg>
                <span class="text-sm font-medium">{{ __('Pinned') }}</span>
            </label>
        </div>
        @endif
    </div>

    <div class="flex items-center space-x-4">
        <div class="relative flex items-center mt-4 md:mt-0">
            <span class="absolute">
                <svg class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </span>

            <input wire:model="search" type="search" placeholder="{{ __('Search all available projects') }}" class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
        </div>

        <div>
            <label class="sr-only" for="sort">
                {{ __('Sort') }}
            </label>

            <select
                wire:model="sort"
                id="sort"
                class="text-gray-500 block w-full py-1.5 transition duration-75 border-gray-200 rounded-lg focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600"
            >
                <option value="recent">{{ __('Recently added') }}</option>
                <option value="order">{{ __('Priority') }}</option>
                <option value="group">{{ __('Group') }}</option>
                <option value="alphabetical">{{ __('Alphabetical') }}</option>
            </select>
        </div>

        @if(auth()->check() && auth()->user()->hasAdminAccess())
        <a href="/admin/projects/create" class="ml-2 px-5 py-2 text-sm text-white bg-blue-500 rounded-lg sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
            <span>{{ __('Create') }}</span>
        </a>
        @endif
    </div>
</div>
@endif

@if($projects->total())
<div class="flex text-sm text-gray-600 my-2">
    @if(!empty($search))
    <p class="mr-1 dark:text-gray-300">{!! __(':number prompts found for the search <strong>":search"</strong>.', ['number' => $projects->total(), 'search' => $search]) !!}</p>
    <button wire:click="resetFilters" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-300">
        {{ __('Clear search.') }}
    </button>
    @endif
</div>

<div class="grid 2xl:grid-cols-3 xl:grid-cols-3 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-5">
    @foreach ($projects as $project)
        <livewire:projects.card :project="$project" wire:key="project-{{ $project->id }}" />
    @endforeach
</div>

<div class="mt-6">
    <x-tables::pagination
        :paginator="$projects"
        :records-per-page-select-options="[16, 32, 48, 64]"
    />
</div>

@else
<div class="flex flex-col w-full bg-white rounded-3xl border border-gray-150 dark:bg-gray-800 dark:border-gray-700 mt-3">
    <div class="flex flex-col justify-center items-center mx-6 mt-5 mb-6">
        <img src="/images/svg/searching.svg" class="mx-auto h-48 text-gray-200 dark:text-gray-700">

        <p class="text-sm text-gray-600 mt-3 dark:text-gray-300">{{ __('No records found.') }}</p>
    </div>
</div>
@endif

</div>
