<div>
    <div class="w-full bg-white shadow-xl rounded-lg flex">
        <div class="flex-1 p-4">
            <div class="h-16 flex items-center justify-between">
                <div class="flex items-center">
                    @if(auth()->check())
                    <a href="{{ route('tickets') }}" class="flex items-center text-gray-700 px-2 py-1 space-x-0.5 border border-gray-300 rounded-lg shadow hover:bg-gray-200 transition duration-100" title="Back">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-bold">{{ __('Back') }}</span>
                    </a>
                    <div class="flex items-center">
                        <span class="bg-gray-300 h-6 w-[.5px] mx-3"></span>
                        <div class="flex items-center space-x-2">
                            <button
                            x-on:confirm="{
                                title: '{{ __('Are you sure you want to delete this ticket?') }}',
                                icon: 'warning',
                                accept: {
                                    label: 'Yes, delete it!',
                                    method: 'delete',
                                },
                                reject: {
                                    label: 'No, cancel',
                                }
                            }"
                                title="{{ __('Delete') }}" class="text-gray-700 px-2 py-1 border border-gray-300 rounded-lg shadow hover:bg-gray-200 transition duration-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="px-2 flex items-center space-x-4">
                    <span class="text-sm text-gray-500">{{ $ticket->created_at->toDayDateTimeString() }}</span>
                </div>
            </div>
            <div class="mb-6">
                <div class="py-6 pl-2 text-gray-700">
                    {!! $ticket->message !!}
                </div>

                @php
                    $attachments = $ticket->getAttachments();
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
    <div class="w-full bg-white shadow-xl rounded-lg p-4 mt-4">
        <form wire:submit.prevent="submit" class="">
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
    <div class="w-full bg-white shadow-xl rounded-lg flex mt-4">
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
</div>
