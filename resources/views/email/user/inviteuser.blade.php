@component('mail::message')
# Welcome To Etibe.NG

@if(isset($invitee)){{ 'Hello ' . $invitee . ',' }}@else {{ 'Hello,' }}@endif

{{ $name }} has invited you to join

**{{ $team->name }}**

__{{ $message }}__

Please click the link below to join.

@component('mail::button', ['url' => $invite_link ])
Accept Invitation
@endcomponent

Any problem with the link above? You can simply copy it below and paste in the browser

{{ $invite_link }}

Thanks,<br />

{{ config('app.name') }}
@endcomponent
