@component('mail::message')
# Dear {{ $content['artist']['agent'] }}

Thank you for the rapid response letting us know that {{ $content['artist']['name'] }} is officially releasing the Hold Position {{ $content['artist']['hold_position'] }} at the {{ $content['event']['name'] }} on {{ $content['event']['date'] }}.<br/>
If you would like to explore mutually agreeable dates for future consideration please check below button.

<h4>Summary:</h4>
-Artist Name: {{ $content['artist']['name'] }}<br/>
-Event Name: {{ $content['event']['name'] }}<br/>
-Location: {{ $content['location']['name'] }}<br/>
<br/>
Thank you,<br/>
{{ $content['admin']['name'] }}<br/>
{{ config('app.name') }}<br/>
E: {{ $content['admin']['email'] }}
@endcomponent