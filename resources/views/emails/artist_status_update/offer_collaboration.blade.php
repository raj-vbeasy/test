@component('mail::message')
# Dear {{ $content['artist']['agent'] }}

Please see the attached offer for consideration of {{ $content['artist']['name'] }} has to perform at the {{ $content['event']['name'] }} on {{ $content['event']['date'] }} in {{ $content['location']['name'] }}.<br/>
Please see the attached venue technical pack and offer.

<h4>Summary:</h4>
-Artist Name: {{ $content['artist']['name'] }}<br/>
-Event Name: {{ $content['event']['name'] }}<br/>
-Location: {{ $content['location']['name'] }}<br/>
-Date: {{ $content['event']['date'] }}<br/>
-Set Time: and Set Length<br/>
-Terms:<br/>
-Offer Expiration Date: {{ $content['offer_expiration_date'] }}<br/>

Please let us know if  you have any questions.<br/>

Thank you,<br/>
{{ $content['admin']['name'] }}<br/>
{{ config('app.name') }}<br/>
E: {{ $content['admin']['email'] }}
@endcomponent