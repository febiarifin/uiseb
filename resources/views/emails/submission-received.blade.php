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
    <p>We have received your submission. Thank you.</p>
    <p>Contribution Details <br>====================</p>
    <table>
        <tr>
            <td>Contribution ID </td>
            <td>: {{ $paper ? $paper->id : $abstrak->id  }}</td>
        </tr>
        <tr>
            <td>Track / Type</td>
            <td>: {{ $abstrak->type_paper }}</td>
        </tr>
        <tr>
            <td>Title</td>
            <td>: {{ $abstrak->title }}</td>
        </tr>
        <tr>
            <td>Author(s)</td>
            <td>: @foreach ($abstrak->penulis as $author)
                {{ $author->last_name }} {{ $author->first_name }},
            @endforeach</td>
        </tr>
        <tr>
            <td>Presenting Author </td>
            <td>: {{ $abstrak->penulis()->first()->last_name }} {{ $abstrak->penulis()->first()->first_name }}</td>
        </tr>
        <tr>
            <td>Presenter's E-Mail</td>
            <td>: {{ $abstrak->penulis()->first()->email }}</td>
        </tr>
    </table>
    <p>Uploaded Files <br>==================== <br>1st file   : On Attachment. </p>
    <p>With best regards,<br>Your UISEB 2024 organizers.</p>
    <p>-- <br>UISEB <br> <a href="{{ url('/') }}">{{ url('/') }}</a></p>
</body>
</html>
