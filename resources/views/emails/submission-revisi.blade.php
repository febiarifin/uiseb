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
    <p>please find your review results below.</p>
    <p>Contribution Details <br>====================</p>
    <table>
        <tr>
            <td>Contribution ID </td>
            <td>: {{ $paper ? $paper->id : $abstrak->id }}</td>
        </tr>
        <tr>
            <td>Title</td>
            <td>: {{ $abstrak->title }}</td>
        </tr>
    </table>
    <p>Review Result of the Program Committee: The decision whether this contribution will be accepted or not is still
        pending.</p>
    <p>Overview of Reviews <br>==================== <br>Revision: <br>
        {!! nl2br($note) !!}
    </p>
    <p>Collect your Full paper in the correct format before
        {{-- {{ $paper ? \Carbon\Carbon::parse($paper->created_at)->addDays(7) : \Carbon\Carbon::parse($abstrak->created_at)->addDays(7) }} <br> --}}
        {{ now()->addDays(7) }} <br>
        The collection of full paper revisions is carried out through gdrive/website as follows: <br> <a
            href="{{ route('abstraks.edit', $abstrak->id) }}">{{ route('abstraks.edit', $abstrak->id) }}</a>
        <br>
        File Name: {{ $abstrak->penulis()->first()->last_name }} {{ $abstrak->penulis()->first()->first_name }}
    </p>
    <p>With best regards,<br>Your UISEB 2024 organizers.</p>
    <p>-- <br>UISEB <br> <a href="{{ url('/') }}">{{ url('/') }}</a></p>
</body>

</html>
