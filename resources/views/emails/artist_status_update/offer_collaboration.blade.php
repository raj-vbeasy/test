@component('mail::message')
# Dear {{ $content['artist']['agent'] }}

Please see the attached offer for consideration of {{ $content['artist']['name'] }} has to perform at the {{ $content['event']['name'] }} on {{ $content['event']['date'] }} in {{ $content['location']['name'] }}.<br/>
Please see the attached venue technical pack and offer.

<h4>Summary:</h4>
-Artist Name: {{ $content['artist']['name'] }}
-Event Name: {{ $content['event']['name'] }}
-Location: {{ $content['location']['name'] }}
-Date: {{ $content['event']['date'] }}
-Set Time: and Set Length
-Terms:
-Offer Expiration Date: {{ $content['offer_expiration_date'] }}

Please let us know if  you have any questions.

Thank you,<br/>
{{ $content['admin']['name'] }}<br/>
{{ config('app.name') }}<br/>
E: {{ $content['admin']['email'] }}
@endcomponent