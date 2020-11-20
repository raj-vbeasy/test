@component('mail::message')
# Dear {{ $content['artist']['agent'] }}

{{ $content['artist']['name'] }} have challenged Hold 1 position and you will get an answer within {{ $content['challenge_expiration_hours'] }} business hours.<br/>

<h4>Summary:</h4>
-Artist Name: {{ $content['artist']['name'] }}
-Event Name: {{ $content['event']['name'] }}
-Location: {{ $content['location']['name'] }}
-Status: {{ $content['artist']['status'] }}
-Hold Position: {{ $content['artist']['hold_position'] }}

Please notify us of any changes in availability as soon as possible.

@component('mail::button', ['url' => $content['url']])
    Select Date
@endcomponent

Thank you,<br/>
{{ $content['admin']['name'] }}<br/>
{{ config('app.name') }}<br/>
E: {{ $content['admin']['email'] }}
@endcomponent