@component('mail::message')
# Dear {{ $content['artist']['agent'] }}

Thank you for the rapid response letting us know that {{ $content['artist']['name'] }} is Not Available to perform on the {{ $content['event']['date'] }} at the {{ $content['event']['name'] }}.<br/>
If you would like to explore mutually agreeable dates for future consideration please click below link.<br/>

<h4>Summary:</h4>
-Artist Name: {{ $content['artist']['name'] }}
-Event Name: {{ $content['event']['name'] }}
-Location: {{ $content['location']['name'] }}

@component('mail::button', ['url' => $content['url']])
    Select Date
@endcomponent

Thank you,<br/>
{{ $content['admin']['name'] }}<br/>
{{ config('app.name') }}<br/>
E: {{ $content['admin']['email'] }}
@endcomponent