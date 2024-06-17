@component('mail::message')
Good day dear {{ $client->name }}

{{$body}}

This is the ZMG Consulting emailing system and we would like to request that you
provide some information to us by clicking the link below. <br>

<a href="{{ url($link) }}">This link will take you to a private page</a><br>

If you do have any question about the process, kindly do give us a call on 061 494 7600/011 022 5555

Kind Regards<br>
ZMG Consulting
@endcomponent
