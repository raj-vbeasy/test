@component('mail::message')
# Dear {{ $content['artist']['agent'] }}

We have received your confirmation of our offer and are looking forward to {{ $content['artist']['name'] }} performance at the {{ $content['event']['name'] }} on {{ $content['event']['date'] }} in {{ $content['location']['name'] }}.<br/>
To submit the publicity assets and links or upload the most current version of the contract and rider(s) click below link.

<h4>Summary:</h4>
-Artist Name: {{ $content['artist']['name'] }}
-Event Name: {{ $content['event']['name'] }}
-Location: {{ $content['location']['name'] }}
-Date: {{ $content['event']['date'] }}
-Set Time: and Set Length
-Terms:

Please let us know if you have any additional questions.

@component('mail::button', ['url' => $content['url']])
    Upload
@endcomponent

Thank you,<br/>
{{ $content['admin']['name'] }}<br/>
{{ config('app.name') }}<br/>
E: {{ $content['admin']['email'] }}
@endcomponent