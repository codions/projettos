@component('mail::message')
**{{ trans('notifications.greeting', ['name' => $user->name]) }}**

{{ trans('notifications.ticket-updated-body', ['subject' => trim($ticket->subject)]) }}

**{{ trans('notifications.latest-activity') }}**
@component('mail::table')
| {{ trans('notifications.log') }} | {{ trans('notifications.date') }} |
|:---:|:---:|
@foreach($activities as $activity)
| {{ ucfirst($activity->description) }} | {{ $activity->created_at }} |
@endforeach
@endcomponent

@component('mail::button', ['url' => route('support.ticket', $ticket->uuid)])
{{ trans('notifications.view-ticket') }}
@endcomponent

{{ trans('notifications.salutation') }}<br>
{{ config('app.name') }}

@endcomponent
