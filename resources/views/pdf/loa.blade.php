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
    <p>We are pleased to inform you that your abstract, entitled:</p>
    <center>
        "{{ $abstrak->title }}"
    </center>
    <p style="text-align: justify;">
        has been reviewed and accepted to be presented at 1ST UNSIQ INTERNATIONAL SYMPOSIUM ON ECONOMICS AND BUSINESS
        2024 (UISEB 2024) which would be held on December 11th 2024 in Wonosobo, Central Java, Indonesia.
    </p>
    <p>Please make the payment for registration fee before the deadlines to as following below:</p>
    <table>
        <tr>
            <td>BANK ACCOUNT </td>
            <td>: BNI</td>
        </tr>
        <tr>
            <td>Bank Account Number </td>
            <td>: 1890999994</td>
        </tr>
        <tr>
            <td>Bank Account Name </td>
            <td>: CV GARUDA RISET INDONESIA</td>
        </tr>
    </table>
    <p>Please kindly confirm with submit your payment receipt on the UISEB 2024’s system. </p>
    <p style="text-align: justify;">For further details, kindly visit at uiseb.feb-unsiq.ac.id or directly contact through our email uiseb-feb@unsiq.ac.id and these following contact number :</p>
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
