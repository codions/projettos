@section('title', $project->title)@show
@section('image', $project->getOgImage($project->description, 'Roadmap - Project'))@show
@section('description', $project->description)@show

<x-app-layout :breadcrumbs="[
    ['title' => 'Projects', 'url' => route('projects.index')],
    ['title' => $project->title, 'url' => route('projects.show', $project)]
]">

    @php
        $board = $project->boards()->visible()->first();
        $params = [
            'project' => $project->id,
            'board' => $board?->id
        ];
    @endphp

    @if ($board)
        <x-filament::button color="secondary" onclick="Livewire.emit('openModal', 'modals.item.create-item-modal', {{ json_encode($params) }})">
            {{ trans('items.create') }}
        </x-filament::button>
    @endif

    <livewire:projects.boards :project="$project" />
</x-app-layout>
