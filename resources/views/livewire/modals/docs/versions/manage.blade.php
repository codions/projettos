@php
    $versions = $this->getVersions();
@endphp

<x-modal>
    <x-slot name="title">
        <div class="flex justify-between items-center">
            <div>
                {{ trans('Manage versions') }}

                <div class="flex flex-row items-center space-x-1">
                    <h5 class="text-sm font-medium text-gray-900 dark:text-white">{{ $doc->title }}</h5>
                </div>
            </div>
            <div class="text-medium">
                <button wire:click="$emit('closeModal')">
                    <x-icon-svg name="x" class="h-6 w-6" />
                </button>
            </div>
        </div>

    </x-slot>

    <x-slot name="content">
        <div class="space-y-4">
            @if ($displayForm)
                <form wire:submit.prevent="save">

                    @if (filled($state['id']))
                        <div class="mb-2">
                            <span class="text-gray-800">{!! trans('You are editing version <strong>:version</strong>', ['version' => $state['title']]) !!}</span>
                        </div>
                    @endif

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ trans('Title') }}</label>
                            <input wire:model.lazy="state.title" type="text" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ trans('eg: v1.0, v1.0-alpha, v1.0-beta, v2.0') }}">
                            @if($errors->has('state.title'))
                                <span class="text-red-500">{{ $errors->first('state.title') }}</span>
                            @endif
                        </div>
                        <div>
                            <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ trans('Slug') }}</label>
                            <input wire:model.lazy="state.slug" type="text" id="slug" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ trans('Format that will appear in the URL') }}">
                            @if($errors->has('state.slug'))
                                <span class="text-red-500">{{ $errors->first('state.slug') }}</span>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-2 py-1.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">{{ trans('Save') }}</button>
                    <button type="button" wire:click="toggleForm" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-2 py-1.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">{{ trans('Cancel') }}</button>
                </form>
            @else

                @if(filled($idForDeletion))
                <div id="alert-additional-content-2" class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                    <div class="flex items-center">
                    <x-icon-svg name="exclamation" class="flex-shrink-0 w-4 h-4 mr-2" />
                    <span class="sr-only">Info</span>
                    <h3 class="text-lg font-semibold">{{ trans('Are you sure you want to delete this version?') }}</h3>
                    </div>
                    <div class="mt-2 mb-4 text-sm">
                    {{ trans('By deleting this version, you also delete all linked pages and subpages.') }}
                    </div>
                    <div class="flex">
                    <button wire:click="deleteVersion({{ $idForDeletion }})" type="button" class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 mr-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        {{ trans('Delete') }}
                    </button>
                    <button wire:click="$set('idForDeletion', null)" type="button" class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800" data-dismiss-target="#alert-additional-content-2" aria-label="Close">
                        {{ trans('Cancel') }}
                    </button>
                    </div>
                </div>
                @endif

                @if ($versions->count())
                <div class="relative overflow-x-auto">
                    <div class="w-full flex flex-row justify-end">
                        <button wire:click="toggleForm" class="text-sm text-gray-500 hover:underline m-4 flex items-center space-x-1">
                            <x-icon-svg name="plus-circle" class="h-4 w-4" />
                            <span>{{ trans('New version') }}</span>
                        </button>
                    </div>
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    {{ trans('Version') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ trans('Slug') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ trans('Pages') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ trans('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($versions as $version)
                            @php $isCurrent = ($version->id === $currentVersionId) @endphp

                            <tr class="border-t dark:bg-gray-900 dark:border-gray-700 bg-white">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <button type="button" wire:click="$emit('loadVersion', {{ $version->id }})" class="text-sm text-gray-500 hover:underline">{{ $version->title }}</button>
                                    @if($isCurrent)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ trans('Current') }}</span>
                                    @endif
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <button type="button" wire:click="$emit('loadVersion', {{ $version->id }})" class="text-sm text-gray-500 hover:underline">{{ $version->slug }}</button>
                                </th>
                                <td class="px-6 py-4">
                                    {{ $version->pages()->count() }}
                                </td>
                                <td class="px-6 py-4 space-x-2 flex flex-row">
                                    <button wire:click="duplicateVersion({{ $version->id }})" class="font-medium hover:text-success-600 dark:text-success-500">
                                        <x-icon-svg name="duplicate" class="w-4 h-4" />
                                    </button>

                                    <button wire:click="editVersion({{ $version->id }})" class="font-medium hover:text-blue-600 dark:text-blue-500">
                                        <x-icon-svg name="pencil-alt" class="w-4 h-4" />
                                    </button>
                                    @if(!$isCurrent)
                                        <button wire:click="$set('idForDeletion', {{ $version->id }})" class="font-medium hover:text-red-600 dark:text-red-500">
                                            <x-icon-svg name="trash" class="w-4 h-4" />
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="border border-2 border-dashed p-6 rounded-xl flex items-center justify-center">
                    <button wire:click="toggleForm" class="text-md text-blue-500 hover:underline m-4 space-x-1">{{ trans('Create first version') }}</button>
                </div>
                @endif
            @endif
        </div>
    </x-slot>
</x-modal>
