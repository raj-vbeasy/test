@component('mail::message')
# Dear {{ $content['artist']['agent'] }}

We are excited to hear that you have indicated that {{ $content['artist']['name'] }} is available for an offer to perform at the {{ $content['event']['name'] }} event beginning on {{ $content['event']['date'] }} - Event End Date: {{ $content['event']['date'] }} in {{ $content['location']['name'] }}.<br/>
Accordingly, {{ $content['artist']['name'] }} has been assigned to the {{ $content['artist']['hold_position'] }} position.<br/>
You will be updated shortly of any status changes as we progress in the event booking process.<br/>

<h4>Summary:</h4>
-Artist Name: {{ $content['artist']['name'] }}
-Event Name: {{ $content['event']['name'] }}
-Event Date: {{ $content['event']['date'] }}
-Location: {{ $content['location']['name'] }}
-Status: {{ $content['artist']['status'] }}
-Hold Position: {{ $content['artist']['hold_position'] }}

Please notify us of any changes in availability as soon as possible.

Thank you,<br/>
{{ $content['admin']['name'] }}<br/>
{{ config('app.name') }}<br/>
E: {{ $content['admin']['email'] }}
@endcomponent