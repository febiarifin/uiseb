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
            <td width="100">Dear, </td>
            <td>: {{ $registration->user->name }}</td>
        </tr>
    </table>
    <p>We are pleased to inform you that your paper titled <br>
    "{{ $abstrak->title }}" has been <b>ACCEPTED</b> for presentation.</p>
    <p style="text-align: justify;">
        As the next step, you are required to prepare an oral video presentation of your work. Please upload the video to your youtube account and provide the link n the UISEB 2024 system. <br><br>
        Additionally, we invite you to join the 1ST UNSIQ INTERNATIONAL SYMPOSIUM ON ECONOMICS AND BUSINESS 2024 (UISEB 2024) on December 11, 2024, via an online platform. We will share the zoom conference link with you shortly.
        <br><br>
        For further details, kindly visit at http.uiseb.feb-unsiq.ac.id or directly contact through our email uiseb-feb@unsiq.ac.id and these following contact number :
    </p>
    <span>+62 897-0251-067 (Moza) <br> +62 895-6328-67644 (Regina)</span>
    <p>Best regards,</p>
    <img src="{{ $stempel }}" height="120" style="margin-left: -20px;">
    {{-- <table>
        <tr>
            <td><img src="{{ $stempel }}" style="" height="100">
            <td><img src="{{ $ttd }}" style="position: relative; left: -20px;" height="100"></td>
            </td>
        </tr>
    </table>
    <p><b><u>Dr. M. Elfan Kaukab, S.E., M.M., M.H.I., Ak.
            </u></b><br>Chairperson of UISEB {{ now()->year }}</p> --}}
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
