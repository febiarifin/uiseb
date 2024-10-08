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
        <span class="fs-18">COPYRIGHT TRANSFER AGREEMENT FORM</span>
    </center>
    <br><br>
    <span>
        Name of Principal/Corresponding Author: {{ $registration->user->name }} <br>
        Address of Principal/Corresponding Author: {{ $registration->user->address }} <br>
        Telephone/Fax: {{ $registration->user->phone_number }} <br>
        Email: {{ $registration->user->email }} <br>
        All Author(s) Name also Affiliation:
        @foreach ($abstrak->penulis as $author)
            {{ $author->last_name }} {{ $author->first_name }} ({{ $author->affiliate }}),
        @endforeach
        <br>
        Title: {{ $abstrak->title }} <br>
    </span>
    <ol style="margin-left: -20px;">
        <li>
            <div style="text-align: justify;">
                We submit the above manuscript to the 1st UISEB (UNSIQ International Symposium Economics and Business)
                Proceeding.
            </div>
        </li>
        <li>
            <div style="text-align: justify;">
                We certify that the work reported here has not been published before and contains no materials the
                publication of which would violate any copyright or other personal or proprietary right or financial
                interests of any person or entity.
            </div>
        </li>
        <li>
            <div style="text-align: justify;">
                We hereby agree to transfer the right to Faculty of Economics and Business, Universitas Sains Al-Qur’an
                who held the 1st UISEB (Unsiq International Syimposium Economics and Business) as following below:
                <ol type="a">
                    <li>The right to process article publication,</li>
                    <li>All proprietary rights including copyright or/ and patent, </li>
                    <li>The right to use all or part of this article in future for any interest</li>
                </ol>
            </div>
        </li>
        <li>
            <div style="text-align: justify;">
                We fully understand that the publication would be processed in proceeding or journal indexed by Scopus,
                WOS and ISSN based on Faculty of Economics and Business, Universitas Sains Al-Qur’an consideration.
            </div>
        </li>
    </ol>
    <p>[Principal/Corresponding Author Name and Article Title]:</p>
    <img src="{{ $signature }}" height="100" style="margin-left: -20px;">
    <p>Valid Signature (original or electronically) here: <br>
        Date: {{ now()->format('d-M-Y') }}</p>
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
