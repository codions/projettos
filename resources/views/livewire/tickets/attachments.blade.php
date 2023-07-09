@php $attachments = $ticket->getAttachments(); @endphp

<div>
    @if($attachments->count())
        <div class="border rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="border-b text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-2 rounded-l-lg">
                            {{ trans('Files') }}
                        </th>
                        <th scope="col" class="px-4 py-2 rounded-r-lg">
                            <span class="sr-only">{{ __('Delete') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attachments as $file)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td scope="row" class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white rounded-l-lg">
                            <div class="flex items-center space-x-2">
                                <div class="w-10 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </div>
                                <div class="w-48 flex flex-col">
                                    <a href="{{ $file->getUrl() }}" target="_blank" class="text-sm text-gray-700 font-bold truncate">{{ $file->file_name }}</a>
                                    <span class="text-gray-500 text-xs">{{ $file->human_readable_size }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-2 text-right rounded-r-lg flex flex-row space-x-2">
                            <a href="{{ $file->getUrl() }}" target="_blank" class="font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                  </svg>
                            </a>
                            <button wire:click="delete('{{ $file->id }}')" class="font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
