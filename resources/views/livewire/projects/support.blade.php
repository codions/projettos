@section('title', $project->title)@show
@section('image', $project->getOgImage($project->description, 'Support - Project'))@show
@section('description', $project->description)@show

<div class="space-y-2">

    <div class="max-w-full mx-auto">
        <div class="lg:flex lg:items-center lg:justify-between">
          <div class="flex-1 min-w-0">
              <h2 class="text-lg tracking-tight font-bold">{{ trans('tickets.created-tickets') }}</h2>
              <p class="text-gray-500 text-sm">{{ trans('tickets.created-tickets-description') }}</p>
          </div>
          <div class="mt-5 flex lg:mt-0 lg:ml-4">

              @php
                  $params = ['project' => $project->id];
              @endphp

              <x-filament::button color="primary" wire:click="$emit('openModal', 'modals.tickets.create', {{ json_encode($params) }})">
                  {{ trans('tickets.new-ticket') }}
              </x-filament::button>
          </div>
        </div>
      </div>

    {{ $this->table }}
</div>