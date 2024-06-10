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
    <h1>Verification Email</h1>
    <p>Congratulations, your registration is successful!</p>
    Please verify your email with bellow link:
    <a href="{{ route('user.verify', $token) }}">Verify Email</a>

</body>
</html>
