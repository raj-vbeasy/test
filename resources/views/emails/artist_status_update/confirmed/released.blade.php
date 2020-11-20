@component('mail::message')
# Dear {{ $content['artist']['agent'] }}

We are writing to inform you that due to the confirmation of an artist with a higher hold position we are officially rescinding the Hold Position {{ $content['artist']['hold_position'] }} for {{ $content['artist']['name'] }} at the {{ $content['event']['name'] }} on {{ $content['event']['date'] }} in {{ $content['location']['name'] }}.<br/>
We wanted to let you know as soon as possible so that you can open the date on your calendar.<br/>
If you would like to explore mutually agreeable dates for future consideration please click below link and let us know any details.

<h4>Summary:</h4>
-Artist Name: {{ $content['artist']['name'] }}<br/>
-Event Name: {{ $content['event']['name'] }}<br/>
-Location: {{ $content['location']['name'] }}<br/>
-Date: {{ $content['event']['date'] }}<br/>

@component('mail::button', ['url' => $content['url']])
    Upload
@endcomponent

Thank you,<br/>
{{ $content['admin']['name'] }}<br/>
{{ config('app.name') }}<br/>
E: {{ $content['admin']['email'] }}
@endcomponent