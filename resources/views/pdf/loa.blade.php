<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        .text-secondary {
            color: #7e7e7e;
        }

        .fs-10 {
            font-size: 10pt;
        }

        .fs-18 {
            font-size: 18pt;
        }

        .fs-14 {
            font-size: 14pt;
        }

        .footer-kop {
            height: 102;
        }
    </style>
</head>

<body>
    <center>
        <img src="{{ $logo }}" height="60">
        <br><span class="text-secondary fs-10">UNSIQ INTERNATIONAL SYMPOSIUM ECONOMICS AND BUSINESS</span>
    </center>
    <hr><br>
    <center>
        <span class="fs-18">LETTER OF ACCEPTANCE</span>
    </center>
    <br><br>
    <table class="fs-14">
        <tr>
            <td width="100">Dear Authors</td>
            <td>: {{ $registration->user->name }}</td>
        </tr>
        <tr>
            <td>Paper Number</td>
            <td>: {{ $registration->id }}</td>
        </tr>
        <tr>
            <td>Entitled</td>
            <td>: {{ $abstrak->title }}</td>
        </tr>
    </table>
    <br><br>
    <p>Greeting form UISEB {{ now()->year }}</p>
    <p style="text-align: justify;">In consideration of your manuscipt presented at UISEB 2024, we are pleased to inform
        you that the
        reviewers have recommended your manuscipt to be published in the UNSIQ International
        Symposnum on Economics and Business with the theme of 'SMEs Competitiveness in Digital Era.
        The symposiumn will be held in Wonosobo, Central Java, Indonesia on December 20, 2024 (08:00-
        15:00 | Jakarta Time) at the Faculty of Economics and Business, Universitas Sains Al-Qur an,
        Wonosobo, n proceedings indexed by ISBN No. 894-342-5434-21-1. The proceedings wvill be
        published in approximately 2 months.</p>
    <p>Thank you,</p>
    <p>With Sincere Appreciation,</p>
    <table>
        <tr>
            <td><img src="{{ $stempel }}" style="" height="100">
            <td><img src="{{ $ttd }}" style="position: relative; left: -20px;" height="100"></td></td>
        </tr>
    </table>
    <p><b><u>Dr. M. Elfan Kaukab, S.E., M.M., M.H.I., Ak.
            </u></b><br>Chairperson of UISEB {{ now()->year }}</p>
    {{-- <img src="{{ $footer_kop }}" class="footer-kop"> --}}
    <hr>
    <table style="padding: 5px; background-color: #f2f2f2;">
        <tr>
            <td width="170" style="text-align: top; vertical-align: top;">
                <p><b>PHONE</b></p>
                <p>(0286) 3396204 <br>+62843583859823 (Rangin) <br> +62876764763428 (Lapis)</p>
            </td>
            <td width="170" style="text-align: top; vertical-align: top;">
                <p><b>WEB & EMAIL</b></p>
                <p>uiseb.feb-unsiq.ac.id <br>uiseb@feb-unsiq.ac.id</p>
            </td>
            <td width="170">
                <p><b>ADDRESS</b></p>
                <p style="text-align: justify;">Faculty of Economics and Business UNSIQ Jl. KH. Hasyim Asy'ari Km. 03,
                    Kalibeber, Kec. Mojotengah, Kab. Wonosobo, Jawa Tengah-56351</p>
            </td>
        </tr>
    </table>
</body>

</html>
