@section('title', $project->title)@show
@section('image', $project->getOgImage($project->description, 'Project'))@show
@section('description', $project->description)@show

@if (!empty($project->description))
<div class="prose w-full h-full">
    {!! $project->description !!}
</div>
@else
<div class="max-w-lg p-6 mx-auto space-y-6 text-center border rounded-2xl dark:border-gray-700">
    <div class="flex flex-col items-center">
        <h1 class="font-bold text-gray-500 text-5xl">{{ __('Oops') }}</h1>

        <p class="mb-2 text-2xl font-semibold text-center text-gray-400">
            {{ __('No description given for project') }}
        </p>
    </div>
</div>
@endif
