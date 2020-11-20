@component('mail::message')
# Dear {{ $content['artist']['agent'] }}

We have received your confirmation of our offer and are looking forward to {{ $content['artist']['name'] }} performance at the {{ $content['event']['name'] }} on {{ $content['event']['date'] }} in {{ $content['location']['name'] }}.<br/>
To submit the publicity assets and links or upload the most current version of the contract and rider(s) click below link.

<h4>Summary:</h4>
-Artist Name: {{ $content['artist']['name'] }}<br/>
-Event Name: {{ $content['event']['name'] }}<br/>
-Location: {{ $content['location']['name'] }}<br/>
-Date: {{ $content['event']['date'] }}<br/>
-Set Time: and Set Length<br/>
-Terms:<br/>

Please let us know if you have any additional questions.

@component('mail::button', ['url' => $content['url']])
    Upload
@endcomponent

Thank you,<br/>
{{ $content['admin']['name'] }}<br/>
{{ config('app.name') }}<br/>
E: {{ $content['admin']['email'] }}
@endcomponent