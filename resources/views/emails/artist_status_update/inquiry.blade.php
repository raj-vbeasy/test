@component('mail::message')
# Hello {{ $content['artist']['agent'] }}

Is {{ $content['artist']['name'] }} available and interested in performing at the "{{ $content['event']['name'] }}" beginning on {{ $content['event']['date'] }} located in the {{ $content['location']['name'] }}.
Please see the venue information below and let me know if you have any questions.

Google Places: <a href="{{ $content['location']['link'] }}">Map Link</a>

Venue Capacity: {{ $content['location']['capacity'] }}

Please let us know if you would like to secure a hold position for {{ $content['event']['name'] }} at your earliest convenience!

Regards,<br/>
{{ $content['admin']['name'] }}<br/>
{{ config('app.name') }}<br/>
E: {{ $content['admin']['email'] }}
@endcomponent