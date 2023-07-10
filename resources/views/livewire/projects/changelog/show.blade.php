@section('title', 'Changelog ' . $changelog->title)@show
@section('image', App\Services\OgImageGenerator::make('View changelog')->withSubject('Changelog')->withFilename('changelog.jpg')->generate()->getPublicUrl())
@section('description', 'View changelog for ' . config('app.name'))

<main class="p-4 h-full flex space-x-10 mx-auto max-w-6xl">
    <section class="flex-1 max-h-full">
        <div class="w-full space-y-8">
            <livewire:projects.changelog.item :changelog="$changelog"/>
        </div>
    </section>
</main>
