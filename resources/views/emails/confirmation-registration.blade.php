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
    <p>Thank you for your registration. You have been registered successfully as a participant. <br>Please log in to the ConfTool system to print out your registration confirmation and invoice.</p>
    <p>The total fee amounts to {{ \App\Helpers\AppHelper::currency($registration->category) }}</p>
    <p>Please transfer the fee to the following bank account during the next 7 days:</p>
    <table>
        <tr>
            <td>Account Holder</td>
            <td>: SCA FEB UNSOED</td>
        </tr>
        <tr>
            <td>Account No.</td>
            <td>: 123 7272 752</td>
        </tr>
        <tr>
            <td>Bank</td>
            <td>: BANK BNI</td>
        </tr>
        <tr>
            <td>Reason for transfer</td>
            <td>: ICSCA2023, ID 1083,ICSCA 2023-0027, ICSCA 2023</td>
        </tr>
    </table>
    <p>Please transfer with a nominal amount according to the provisions.</p>
    <p>Direct Link to Invoice and Registration Confirmation: <br>{{ route('print.invoice', base64_encode($registration->id)) }}</p>
    <p>With best regards,<br>Your UISEB 2024 organizers.</p>
    <p>-- <br>UISEB <br> <a href="{{ url('/') }}">{{ url('/') }}</a></p>
</body>
</html>
