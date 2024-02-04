@component('mail::message')
Dear {{ $user->name }} {{ $user->surname  }}

{{$body}}

Thanks John,<br>
eClaims
@endcomponent
