@section('title', $project->title)@show
@section('image', $project->getOgImage($project->description, 'Roadmap - Project'))@show
@section('description', $project->description)@show

<x-app-layout :breadcrumbs="[
    ['title' => 'Projects', 'url' => route('projects.index')],
    ['title' => $project->title, 'url' => route('projects.show', $project)]
]">
    <livewire:projects.boards :project="$project" />
</x-app-layout>
