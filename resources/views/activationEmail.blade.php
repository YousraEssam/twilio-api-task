@component('mail::message')

Welcome {{ $data['user_email'] }}

Your Activation Code is: {{ $data['code'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
