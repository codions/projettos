<x-filament::page>
    <div class="w-full bg-white shadow rounded-xl flex">
        <div class="flex-1 p-4">
            <div class="h-16 flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/admin/tickets" class="flex items-center text-gray-700 px-2 py-1 space-x-0.5 border border-gray-300 rounded-lg shadow hover:bg-gray-200 transition duration-100" title="Back">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-bold">{{ __('Back') }}</span>
                    </a>
                    <div class="flex items-center">
                        <span class="bg-gray-300 h-6 w-[.5px] mx-3"></span>
                        <div class="flex items-center space-x-2">

                            @if($record->is_spam)
                            <button wire:click="toggleSpam" title="{{ __('Mark as spam') }}" class="text-red-700 px-2 py-1 border border-red-300 rounded-lg shadow bg-red-100 hover:bg-red-200 transition duration-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </button>
                            @else
                            <button wire:click="toggleSpam" title="{{ __('Unmark as spam') }}" class="text-gray-700 px-2 py-1 border border-gray-300 rounded-lg shadow hover:bg-gray-200 transition duration-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </button>
                            @endif

                            <button wire:click="delete" title="{{ __('Delete') }}" class="text-gray-700 px-2 py-1 border border-gray-300 rounded-lg shadow hover:bg-gray-200 transition duration-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                        <span class="bg-gray-300 h-6 w-[.5px] mx-3"></span>
                        <div class="flex items-center space-x-2">
                            <button wire:click="markAsUnread()" title="{{ __('Mark as unread') }}" class="text-gray-700 px-2 py-1 border border-gray-300 rounded-lg shadow hover:bg-gray-200 transition duration-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="px-2 flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        @if($next)
                        <a href="/admin/tickets/{{ $next }}/view" class="bg-gray-200 hover:bg-gray-300 text-gray-700 p-1.5 rounded-lg transition duration-150" title="Previous Email">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        @endif

                        @if($previous)
                        <a href="/admin/tickets/{{ $previous }}/view" class="bg-gray-200 hover:bg-gray-300 text-gray-700 p-1.5 rounded-lg transition duration-150" title="Nex Email">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mb-6">
                <h4 class="text-lg text-gray-800 font-bold pb-2 mb-4 border-b-2">#{{ $record->id }} - {{ $record->subject }}</h4>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ $record->profile_picture }}" class="rounded-full w-8 h-8 border border-gray-500">
                        <div class="flex flex-col ml-2">
                            <span class="text-sm font-semibold">{{ $record->name }}</span>
                            <span class="text-xs text-gray-400">{{ $record->email }}</span>
                        </div>
                    </div>
                    <span class="text-sm text-gray-500">{{ $record->created_at->toDayDateTimeString() }}</span>
                </div>
                <div class="py-6 pl-2 text-gray-700">
                    {!! $record->message !!}
                </div>

                @php
                    $attachments = $record->getAttachments();
                @endphp
                @if($attachments->count())
                    <div class="border-t-2 flex flex-wrap py-4">
                        @foreach($attachments as $file)
                        <div class="w-70 flex items-center m-1 py-2.5 px-2 border-2 border-gray-300 rounded-lg hover:bg-gray-200">
                            <div class="flex items-center">
                                <div class="w-10 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                      </svg>
                                </div>
                                <div class="w-48 ml-2 flex flex-col">
                                    <a href="{{ $file->getUrl() }}" target="_blank" class="text-sm text-gray-700 font-bold truncate">{{ $file->file_name }}</a>
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
                <div class="mt-8 flex items-center space-x-4">
                    <button wire:click="$set('showReplyForm', true)" class="w-32 flex items-center justify-center space-x-2 py-1.5 text-gray-600 border border-gray-400 rounded-lg hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ __('Reply') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if($showReplyForm)
    <div class="w-full bg-white shadow rounded-xl p-4">
        <form wire:submit.prevent="submit">
            {{ $this->form }}

            <div class="mt-3">
                <x-filament::button type="submit">
                    {{ __('Send') }}
                </x-filament::button>
                
                <x-filament::button color="danger" wire:click.prevent="$set('showReplyForm', false)">
                    {{ __('Cancel') }}
                </x-filament::button>
            </div>
        </form>
    </div>
    @endif

    @foreach($replies as $reply)
    <div class="w-full bg-white shadow rounded-xl flex">
        <div class="flex-1 p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ $reply->profile_picture }}" class="rounded-full w-8 h-8 border border-gray-500">
                    <div class="flex flex-col ml-2">
                        <span class="text-sm font-semibold">{{ $reply->name }}</span>
                        <span class="text-xs text-gray-400">{{ $reply->email }}</span>
                    </div>
                </div>
                <span class="text-sm text-gray-500">{{ $reply->created_at->toDayDateTimeString() }}</span>
            </div>
            <div class="py-6 pl-2 text-gray-700">
                {!! $reply->message !!}
            </div>

            @php
                $replyAttachments = $reply->getAttachments();
            @endphp
            @if($replyAttachments->count())
                <div class="border-t-2 flex flex-wrap py-4">
                    @foreach($replyAttachments as $file)
                    <div class="w-70 flex items-center m-1 py-2.5 px-2 border-2 border-gray-300 rounded-lg hover:bg-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                  </svg>
                            </div>
                            <div class="w-48 ml-2 flex flex-col">
                                <a href="{{ $file->getUrl() }}" target="_blank" class="text-sm text-gray-700 font-bold truncate">{{ $file->file_name }}</a>
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
    @endforeach
</x-filament::page>
