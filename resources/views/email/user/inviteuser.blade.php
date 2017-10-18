@component('mail::message')
# Welcome To Etibe.NG

@isset($invitee){{ 'Hello ' . $invitee . ',' }}@else {{ 'Hello,' }}@endisset

{{ $name }} has invited you to join

**{{ $team->name }}**

@isset($message) __{{ $message }}__ @endisset

Please click the link below to join.

@component('mail::button', ['url' => "$invite_link" ])
Accept Invitation
@endcomponent

Any problem with the link above? You can simply copy it below and paste in the browser

{{ $invite_link }}

Thanks,<br />

{{ config('app.name') }}
@endcomponent
