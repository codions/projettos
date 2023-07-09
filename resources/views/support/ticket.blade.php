@section('title', trans('support.support'))

<x-app :breadcrumbs="[
    ['title' => trans('support.support'), 'url' => route('support')],
    ['title' => $ticket->code, 'url' => route('support.ticket', $ticket->uuid)],
]">
    <div>
        <livewire:tickets.show :ticket="$ticket" />
    </div>
</x-app>
