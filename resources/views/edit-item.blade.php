@section('title', 'Edit ' . $item->title)
@section('image', $item->getOgImage('"' . $item->excerpt .'"', 'Roadmap - Item'))
@section('description', $item->excerpt)

<x-app :breadcrumbs="[
['title' => 'Dashboard', 'url' => route('home')],
['title' => $item->title, 'url' => route('items.show', $item)],
]">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            <livewire:items.edit :item="$item" />
        </div>
    </div>
</x-app>
