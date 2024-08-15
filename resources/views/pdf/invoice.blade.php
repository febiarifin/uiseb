<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        * {
            font-family: sans-serif;
        }

        .text-secondary {
            color: #7e7e7e;
        }
        .text-white {
            color: #fff;
        }

        .text-danger {
            color: red;
        }

        .text-success {
            color: green;
        }

        .fs-20 {
            font-size: 20pt;
        }

        .fs-16 {
            font-size: 16pt;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .table-bordered {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
        .fw-bold{
            font-weight: bold;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td width="300">
                <img src="{{ $logo }}" height="80">
            </td>
            <td style="text-align: right; vertical-align:top;">
                <span class="text-secondary fs-20">PAYMENT RECEIPT</span> <br>
                @if ($registration->is_valid)
                    <span class="fs-16 text-success">PAID</span>
                @else
                    <span class="fs-16 text-danger">UNPAID</span>
                @endif
            </td>
        </tr>
    </table>
    <br>
    <span class="fs-16 text-secondary">Receipt:</span>
    <table class="text-secondary">
        <tr>
            <td>Name</td>
            <td>: {{ $registration->user->name }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>: {{ $registration->user->email }}</td>
        </tr>
        <tr>
            <td>Institution</td>
            <td>: {{ $registration->user->institution }}</td>
        </tr>
    </table>
    <br>
    <table class="table-bordered">
        <tr bgcolor="red">
            <th class="table-bordered text-white" width="30">#</th>
            <th class="table-bordered text-white" width="320">Item Description</th>
            <th class="table-bordered text-white" width="150">Price</th>
        </tr>
        <tr>
            <td class="table-bordered text-secondary">1</td>
            <td class="table-bordered text-secondary">{{ $registration->category->name }}  @if ($registration->category->is_paper)
                + PAPER
            @endif</td>
            <td class="table-bordered text-secondary">{{ \App\Helpers\AppHelper::currency($registration->category) }}</td>
        </tr>
        <tr>
            <td colspan="2" class="table-bordered text-secondary">AMOUNT TOTAL</td>
            <td class="table-bordered text-secondary fw-bold">{{ \App\Helpers\AppHelper::currency($registration->category) }}</td>
        </tr>
    </table>
    @if ($registration->is_valid)
    <p class="text-secondary">Payment in full has been received. Thank you.</p>
    @endif
    <p class="text-secondary">With best regards,<br>Your UISEB 2024 organizers.</p>
    <p class="text-secondary">-- <br>UISEB <br> <a href="{{ url('/') }}">{{ url('/') }}</a></p>
</body>

</html>
