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
    <p>A payment of {{ \App\Helpers\AppHelper::currency($registration->category) }} for participant {{ $user->name }}  has been processed and was recorded in the uiseb website system. Thank you!</p>
    <p>Payment Details <br>====================================</p>
    <table>
        <tr>
            <td>Method of Payment </td>
            <td>: BANK TRANSFER</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>: {{ now() }}</td>
        </tr>
        <tr>
            <td>Payment Amount   </td>
            <td>: {{ \App\Helpers\AppHelper::currency($registration->category) }} </td>
        </tr>
        <tr>
            <td>Payment Details </td>
            <td>: Your money transfer has been received. Thank you.</td>
        </tr>
    </table>
    <span>====================================</span>
    <p>With best regards,<br>Your UISEB 2024 organizers.</p>
    <p>-- <br>UISEB <br> <a href="{{ url('/') }}">{{ url('/') }}</a></p>
</body>

</html>
