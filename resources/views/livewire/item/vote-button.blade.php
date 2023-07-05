<div>
    <div class="flex items-center space-x-4 p-1">
        @if($model->board?->block_votes)
            <x-filament::button
                color="secondary"
                disabled
            >
                <x-heroicon-o-thumb-up class="w-5 h-5"/>
            </x-filament::button>
        @else
            <x-filament::button
                :color="$vote ? 'primary' : 'secondary'"
                wire:click="toggleUpvote"
            >
                <x-heroicon-o-thumb-up class="w-5 h-5"/>
            </x-filament::button>
        @endif

        <span>{{ trans_choice('messages.total-votes', $model->total_votes, ['votes' => $model->total_votes]) }}</span>

        @if($vote && $showSubscribeOption)
            @if($vote->subscribed)
                <button class="border-b border-dotted font-semibold border-gray-500" x-data
                        x-tooltip.raw="{{ trans('items.unsubscribe-tooltip') }}" wire:click="unsubscribe">
                    {{ trans('items.unsubscribe') }}
                </button>
            @else
                <button class="border-b border-dotted font-semibold border-gray-500" x-data
                        x-tooltip.raw="{{ trans('items.subscribe-tooltip') }}" wire:click="subscribe">
                    {{ trans('items.subscribe') }}
                </button>
            @endif
        @endif
    </div>
    <div class="py-1 mx-2">
        @if(app(\App\Settings\GeneralSettings::class)->show_voter_avatars)
            @if($this->recentVoters->count() > 0)
                <div class="flex -space-x-2">
                    @foreach($this->recentVoters as $voter)
                        <img src="{{ $voter['avatar'] }}"
                             class="inline object-cover w-8 h-8 border-2 border-white rounded-full dark:border-gray-800"
                             alt="{{ $voter['name'] }}" x-data x-tooltip.raw="{{ $voter['name'] }}">
                        @if($loop->last && $this->model->votes->count() > $this->recentVotersToShow)
                            <a class="shrink-0 flex items-center justify-center w-8 h-8 text-xs font-medium text-white bg-gray-400 border-2 border-white rounded-full cursor-auto"
                               href="#">+ {{ $this->model->votes->count() - $this->recentVotersToShow }} </a>
                        @endif
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</div>
