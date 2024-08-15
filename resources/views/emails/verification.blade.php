<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <img src="{{ asset('manup-master/img/logo_UISEB.png') }}" height="100">
    <p>Dear Mr/Mrs {{ $user->name }}</p>
    <p>You now have a user account for the UISEB website system.</p>
    <p>Event: UISEB <br>Login page: <a href="{{ url('/') }}">{{ url('/') }}</a></p>
    <p>Your Username: {{ $user->name }}</p>
    <p style="text-align: justify">If the above account is yours and the e-mail address {{ $user->email }}  belongs to you, please validate your e-mail by selecting the following link (one line): <br> <a href="{{ route('user.verify', $token) }}">{{ route('user.verify', $token) }}</a></p>
    <p>You may also copy the address into the address bar of your browser.</p>
    <p>After validation you will get access to the contributions for which you were listed as co-author if you are the co-author of a submission. Please note that the e-mail address in the contribution details must match this address. If you still do not have access to the paper please check that your submitting author has listed the correct address.</p>
    <p>With best regards,<br>Your UISEB 2024 organizers.</p>
    <p>-- <br>UISEB <br> <a href="{{ url('/') }}">{{ url('/') }}</a></p>
</body>
</html>
