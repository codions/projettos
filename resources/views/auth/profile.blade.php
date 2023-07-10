@section('title', trans('auth.profile'))

<x-app-layout :breadcrumbs="[
    ['title' => trans('auth.profile'), 'url' => route('profile')]
]">
    <livewire:profile />
</x-app-layout>
