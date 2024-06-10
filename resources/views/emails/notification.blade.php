<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <img src="{{ \App\Helpers\AppHelper::convert_base64('public/manup-master/img/logo_UISEB.png') }}" height="100">
    {{-- <img src="{{ asset('manup-master/img/logo_UISEB.png') }}" height="100"> --}}
    <p>{!! nl2br($details['message']) !!}</p>
    <p>Messages are sent automatically, no need to reply</p>
</body>
</html>
