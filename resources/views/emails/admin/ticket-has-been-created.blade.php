@component('mail::message')
**Hi {{ $receiver['name'] }}**,

A new ticket has been created with the subject **{{ trim($ticket->subject) }}**.

@component('mail::button', ['url' => route('support.ticket', $ticket->uuid)])
View ticket
@endcomponent

Best regards,<br>
{{ config('app.name') }}
@endcomponent
