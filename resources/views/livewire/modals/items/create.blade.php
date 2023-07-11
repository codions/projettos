<x-modal>
    <x-slot name="title">
        <div class="flex justify-between items-center">
            <div>
                {{ trans('items.add_suggestion') }}

                @if ($project?->title)
                <div class="flex flex-row items-center space-x-1">
                    <h5 class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->title }}</h5>

                    @if($board?->title)
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ $board->title }}</span>
                    @endif
                </div>
                @endif
            </div>
            <div class="text-medium">
                <button wire:click="$emit('closeModal')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

    </x-slot>

    <x-slot name="content">
        @auth
            @if(! auth()->user()->needsToVerifyEmail())
                <div @class(['hidden' => !$similarItems->count()])>
                    <h3 class="mb-2">{{ trans('items.similar-results') }}</h3>
                    <ul class="max-h-20 overflow-y-auto list-disc list-inside">
                        @foreach($similarItems as $similarItem)
                            <li>
                                <a href="{{ route('items.show', $similarItem->slug ?? '') }}"
                                class="border-b border-brand-500 border-dotted text-brand-500 hover:text-brand-700">
                                    <span class="truncate"> {{ $similarItem->title }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{ $this->form }}
            @else
            <div class="alert-info">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="border-b border-dotted border-blue-500 font-semibold">{{ __('click here to request another') }}</button>.
                </form>
            </div>
            @endif
        @endauth
        @guest
            <p>{{ trans('items.login_to_submit_item') }}</p>
        @endguest
    </x-slot>

    <x-slot name="buttons">
        @auth
            @if(!auth()->user()->needsToVerifyEmail())
                <x-filament::button wire:click="submit">
                    {{ trans('items.create') }}
                </x-filament::button>
            @endif()
        @endauth

        <x-filament::button color="secondary" wire:click="$emit('closeModal')">
            {{ trans('general.close') }}
        </x-filament::button>
    </x-slot>
</x-modal>
