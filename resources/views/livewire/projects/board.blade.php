@section('title', $project->title . ' - ' . $board->title)@show
@section('image', $board->getOgImage($board->description, 'Roadmap - Board'))@show
@section('description', $board->description)@show

<main class="p-4 h-full flex space-x-10 mx-auto max-w-6xl">
    <section class="flex-1 max-h-full overflow-y-scroll">
        <livewire:items.index :project="$project" :board="$board"/>
    </section>

    @if($board->canUsersCreateItem())
        <section class="w-96 sticky top-0">
            <div class="bg-white rounded-lg shadow p-5">
                <livewire:items.create :project="$project" :board="$board"/>
            </div>
        </section>
    @endif
</main>
