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
        <span class="fs-18">SUBMISSION DECLARATION FORM</span>
    </center>
    <br><br>
    <span>
        PROPOSED TITLE OF MANUSCRIPT: {{ $abstrak->title }} <br>
        CORRESPONDING AUTHOR:
        @foreach ($abstrak->penulis()->where('coresponding', 1)->get() as $author)
            {{ $author->last_name }} {{ $author->first_name }} ({{ $author->affiliate }})
        @endforeach <br>
        CO AUTHORS: {{ $registration->user->name }}
    </span>
    <ul style="margin-left: -20px;">
        <li>
            <div style="text-align: justify;">
                I confirm that I have read, understand, and agreed to the submission guidelines, policies, and
                submission declaration of the journal.
            </div>
        </li>
        <li>
            <div style="text-align: justify;">
                I confirm that all authors of the manuscript have no conflict of interests to declare.
            </div>
        </li>
        <li>
            <div style="text-align: justify;">
                I confirm that the manuscript is the authors' original work and the manuscript has not received prior
                publication and is not under consideration for publication elsewhere.
            </div>
        </li>
        <li>
            <div style="text-align: justify;">
                On behalf of all Co-Authors, I shall bear full responsibility for the submission.
            </div>
        </li>
        <li>
            <div style="text-align: justify;">
                I confirm that all authors listed on the title page have contributed significantly to the work, have
                read the manuscript, attest to the validity and legitimacy of the data and its interpretation, and agree
                to its submission.
            </div>
        </li>
        <li>
            <div style="text-align: justify;">
                I confirm that the paper now submitted is not copied or plagiarized version of some other published
                work.
            </div>
        </li>
        <li>
            <div style="text-align: justify;">
                I declare that I shall not submit the paper for publication in any other Journal or Magazine till the
                decision is made by journal editors.
            </div>
        </li>
        <li>
            <div style="text-align: justify;">
                If the paper is finally accepted by the journal for publication, I confirm that I will either publish
                the paper immediately or withdraw it according to withdrawal policies.
            </div>
        </li>
        <li>
            <div style="text-align: justify;">
                I understand that submission of false or incorrect information/undertaking would invite appropriate
                penal actions as per norms/rules of the journal and EDP guidelines.
            </div>
        </li>
    </ul>
    <table>
        <tr>
            <td width="400"></td>
            <td>Date: {{ now()->format('d-M-Y') }}</td>
        </tr>
        <tr>
            <td>
                <span>Authors</span> <br>
                <img src="{{ $signature }}" height="100" style="margin-left: -20px;"> <br>
                <span>Signature of Corresponding Author <br>
                    (Signed on behalf of all authors)
                </span>
            </td>
        </tr>
    </table>
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
