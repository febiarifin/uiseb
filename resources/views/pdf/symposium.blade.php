<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        *{
            font-family: sans-serif;
        }
        .text-secondary{
            color: #7e7e7e;
        }
        .text-danger{
            color: red;
        }
        .fs-20{
            font-size: 20pt;
        }
        .fs-16{
            font-size: 16pt;
        }
        .text-uppercase{
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td width="350">
                <img src="{{ $logo }}" height="80">
                <br><br>
                <span class="text-danger">UNSIQ International Symposium on Economics and Busines</span><br>
                <span class="text-secondary">Faculty of Economic and Busines</span><br>
                <span class="text-secondary">Universitas Sains Al-Qur'an, Wonosobo</span><br>
            </td>
            <td style="text-align: right; vertical-align:top;" width="150">
                <span class="text-danger fs-20">{{ $registration->user->name }}</span> <br>
                <span>{{ $registration->user->email }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;" height="100">
                <span class="text-uppercase text-danger">SUBJECT: {{ $registration->category->name }}</span>
            </td>
        </tr>
    </table>
</body>
</html>
