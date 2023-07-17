@section('title', trans('support.support'))

<div class="space-y-4">

    <div class="max-w-full mx-auto">
     @if ($ticket->project?->title)
        <div class="mb-3">
            <a href="{{ route('projects.support', $ticket->project) }}" class="text-lg font-bold text-gray-900 dark:text-white hover:underline">
                {{ $ticket->project->title }}
            </a>
        </div>
     @endif

      <div class="lg:flex lg:items-center lg:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-lg tracking-tight font-bold">#{{ $ticket->code }} - {{ $ticket->subject }}</h2>

            <div class="flex items-center space-x-2">
                <span class="bg-gray-100 text-gray-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                    {{ $ticket->status_label }}
                </span>

                <p class="text-gray-500 dark:text-gray-300 text-sm">{{ trans('general.last-updated-by-user-at-datetime', [
                    'user' => $ticket->lastUpdatedBy()?->name ?? '--',
                    'datetime' => $ticket->updated_at->toDayDateTimeString(),
                ]) }}</p>
            </div>
        </div>
        <div class="mt-5 flex lg:mt-0 lg:ml-4 space-x-2">
            @if(!$ticket->is_closed)
            <x-filament::button color="secondary" wire:click="$emit('openModal', 'modals.tickets.update-status', {{ json_encode(['ticket' => $ticket->id, 'status' => 'closed']) }})">
                {{ trans('tickets.close-ticket') }}
            </x-filament::button>
            @endif

            <button wire:click="$emit('openModal', 'modals.tickets.activities', {{ json_encode(['ticket' => $ticket->id]) }})" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 448 448" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path d="M234.667 138.667v106.666l91.306 54.187 15.36-25.92-74.666-44.267v-90.666z" fill="#000000" data-original="#000000" class=""></path><path d="M255.893 32C149.76 32 64 117.973 64 224H0l83.093 83.093 1.493 3.093L170.667 224h-64c0-82.453 66.88-149.333 149.333-149.333S405.333 141.547 405.333 224 338.453 373.333 256 373.333c-41.28 0-78.507-16.853-105.493-43.84L120.32 359.68C154.987 394.453 202.88 416 255.893 416 362.027 416 448 330.027 448 224S362.027 32 255.893 32z" fill="#000000" data-original="#000000" class=""></path>
                </svg>
            </button>

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                        </svg>
                    </button>
                </x-slot>

                @if(auth()->user()->hasAdminAccess())
                    <x-dropdown.item wire:click="markAsUnread">
                        {{ trans('tickets.mark-as-unread') }}
                    </x-dropdown.item>
                @endif

                @if($ticket->canBeEdited())
                <x-dropdown.item :label="trans('tickets.edit')" wire:click="$emit('openModal', 'modals.tickets.edit', {{ json_encode(['ticket' => $ticket->id]) }})" />
                @endif

                @if ($ticket->canBeDeleted())
                <x-dropdown.item :label="trans('tickets.delete')" wire:click="delete" />
                @endif
            </x-dropdown>

        </div>
      </div>
    </div>

    <livewire:tickets.card :ticket="$ticket" :wire:key="'ticket-'.$ticket->id" />

    @foreach($replies as $reply)
        <livewire:tickets.card :ticket="$reply" :wire:key="'reply-'.$reply->id" />
    @endforeach

    <div class="w-full bg-white shadow rounded-xl p-4 mt-4">

        @if($ticket->is_closed)
            <div class="flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <p>This ticket is closed and can no longer receive responses.</p>
            </div>
        @else
        <form wire:submit.prevent="submit" class="">
            {{ $this->form }}

            <div class="mt-3">
                <x-filament::button type="submit">
                    {{ __('Send') }}
                </x-filament::button>
            </div>
        </form>
        @endif
    </div>
</div>
