@section('title', trans('auth.profile'))

<x-layouts.app :breadcrumbs="[
    ['title' => trans('auth.profile'), 'url' => route('profile')]
]">
    <livewire:profile />
</x-layouts.app>
