@component('mail::message')
# Dear {{ $content['artist']['agent'] }}

Thank you for indicating that {{ $content['artist']['name'] }} is available for the {{ $content['event']['name'] }} event beginning on {{ $content['event']['date'] }} in {{ $content['location']['name'] }}.<br/>
Accordingly, you will be updated if we decide to move forward with assigning a hold position.

<h4>Summary:</h4>
-Artist Name: {{ $content['artist']['name'] }}<br/>
-Event Name: {{ $content['event']['name'] }}<br/>
-Event Date: {{ $content['event']['date'] }}<br/>
-Location: {{ $content['location']['name'] }}<br/>
-Status: {{ $content['artist']['status'] }}<br/>

Please notify us of any changes in availability as soon as possible.

Thank you,<br/>
{{ $content['admin']['name'] }}<br/>
{{ config('app.name') }}<br/>
E: {{ $content['admin']['email'] }}
@endcomponent