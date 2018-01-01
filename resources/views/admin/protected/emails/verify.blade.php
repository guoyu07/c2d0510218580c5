@component('mail::message')

Hi <b>{{ $user->name }}</b><br>
Thank you for signing up!
Please verify Your Email Address by clicking the button below.

@component('mail::button', ['url' => $user->link])
Confirm my account
@endcomponent

If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser
<br>{!! $user->link !!}
<br>

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
