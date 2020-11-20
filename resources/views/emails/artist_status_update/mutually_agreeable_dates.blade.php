@component('mail::message')
# Dear {{ $content['artist']['agent'] }}

Let's connect! We are excited to hear that {{ $content['artist']['name'] }} is willing to discuss Mutually Agreeable Dates for an upcoming performance at the {{ $content['event']['name'] }} in {{ $content['location']['name'] }}.<br/>
Please reply with potential timeframes and or days that would work into your scheduling.<br/>

<h4>Summary:</h4>
-Artist Name: {{ $content['artist']['name'] }}
-Event Name: {{ $content['event']['name'] }}
-Location: {{ $content['location']['name'] }}
-Status: {{ $content['artist']['status'] }}
-Position: {{ $content['artist']['hold_position'] }}

Please notify us of any changes in availability as soon as possible.

@component('mail::button', ['url' => $content['url']])
    Select Date
@endcomponent

Thank you,<br/>
{{ $content['admin']['name'] }}<br/>
{{ config('app.name') }}<br/>
E: {{ $content['admin']['email'] }}
@endcomponent