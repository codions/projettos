@component('mail::message')
**Hi {{ $receiver['name'] }}**,

A new version of the roadmap software has been releases.

@component('mail::button', ['url' => 'https://github.com/codions/projettos/releases'])
View releases at GitHub
@endcomponent

Best regards,<br>
{{ config('app.name') }}
@endcomponent
