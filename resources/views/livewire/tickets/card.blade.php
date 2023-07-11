<div class="w-full bg-white shadow rounded-xl flex mt-4 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex-1 p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img src="{{ $ticket->user->profile_picture }}" class="rounded-full w-8 h-8 border border-gray-500">
                <div class="flex flex-col ml-2">
                    <span class="text-sm font-semibold">{{ $ticket->user->name }}</span>
                    <span class="text-xs text-gray-400">{{ $ticket->user->email }}</span>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <time class="text-sm text-gray-500 dark:text-gray-300" datetime="{{ $ticket->created_at->toIso8601String() }}">{{ $ticket->created_at->diffForHumans() }}</time>
                @if(!$ticket->is_root && $ticket->canBeEdited())
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-gray-500 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown.item wire:click="$emit('openModal', 'modals.tickets.edit', {{ json_encode(['ticket' => $ticket->id]) }})">
                            {{ trans('tickets.edit') }}
                        </x-dropdown.item>

                        <x-dropdown.item wire:click="delete">
                            {{ trans('tickets.delete') }}
                        </x-dropdown.item>

                    </x-slot>
                </x-dropdown>
                @endif
            </div>
        </div>
        <div class="py-6 pl-2 text-gray-700 dark:text-white">
            {!! $ticket->message !!}
        </div>

        @php $attachments = $ticket->getAttachments(); @endphp
        @if($attachments->count())
            <div class="border-t-2 flex flex-wrap py-4 dark:border-gray-600">
                @foreach($attachments as $file)
                <div class="w-70 flex items-center m-1 py-2.5 px-2 border-2 border-gray-300 rounded-lg hover:bg-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                    <div class="flex items-center">
                        <div class="w-10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                        </div>
                        <div class="w-48 ml-2 flex flex-col">
                            <a href="{{ $file->getUrl() }}" target="_blank" class="text-sm text-gray-700 font-bold truncate dark:text-white">{{ $file->file_name }}</a>
                            <span class="text-gray-500 text-xs">{{ $file->human_readable_size }}</span>
                        </div>
                    </div>
                    <a href="{{ $file->getUrl() }}" target="_blank" class="w-6 flex items-center justify-center" title="Download">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-500 hover:text-gray-600 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </a>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
