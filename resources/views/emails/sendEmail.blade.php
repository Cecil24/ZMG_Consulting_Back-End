@component('mail::message')
    Hi {{ $user->name  }} {{$user->surname}},

    Your OTP is {{ $otp }}

    Thanks,<br>
    ZMG Consulting
@endcomponent
