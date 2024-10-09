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
    <p>Dear Mr/Mrs <br>
        @foreach ($abstrak->penulis as $author)
            {{ $author->last_name }} {{ $author->first_name }} <br>
        @endforeach
    </p>
    <p>We sincerely appreciate your paper submission. On conclusion of the peer-reviewed process, we are pleased to
        inform you that your paper is accepted for presentation at UISEB {{ now()->year }} in Indonesia. The schedule
        of your presentation session will be sent to your registered email.</p>
    @if (!$paper)
        <p>Please kindly make the payment to our bank account with the following account number:</p>
        <table>
            <tr>
                <td>Account Name </td>
                <td>: CV GARUDA RISET INDONESIA</td>
            </tr>
            <tr>
                <td>Account Number </td>
                <td>: 1890999994 </td>
            </tr>
            <tr>
                <td>Bank </td>
                <td>: BANK BNI</td>
            </tr>
            <tr>
                <td>Branch </td>
                <td>: FACULTY ECONOMIC AND BUSINES UNSIQ</td>
            </tr>
            <tr>
                <td>Purposes </td>
                <td>: Presenter UISEB 2024 </td>
            </tr>
        </table>
        <p>Please make payment before
            {{ $paper ? \Carbon\Carbon::parse($paper->acc_at)->addDays(7) : \Carbon\Carbon::parse($abstrak->acc_at)->addDays(7) }}
            Send us the proof of payment via <a
                href="{{ route('upload.payment', $abstrak->registration->id) }}">{{ route('upload.payment', $abstrak->registration->id) }}</a>
            to confirm your payment.</p>
    @endif
    <p>If you have any further questions, please contact the secretariat of UISEB by sending your email with your
        manuscript ID number.</p>
    <p>With best regards,<br>Your UISEB 2024 organizers.</p>
    @if ($abstrak->papers()->where('status', \App\Models\Paper::ACCEPTED)->first())
        <p>Link LOA: <br>
            {{ route('print.loa', [base64_encode($abstrak->registration->id), 'loa-paper']) }}
        </p>
    @else
        <p>Link LOA: <br>
            {{ route('print.loa', [base64_encode($abstrak->registration->id), 'loa']) }}
        </p>
    @endif
    <p>We look forward to seeing...</p>
    <p>-- <br>UISEB <br> <a href="{{ url('/') }}">{{ url('/') }}</a></p>
</body>

</html>
