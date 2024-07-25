<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .column {
            float: left;
            width: 50%;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <img src="{{ $logo }}" height="80">
    <br><br>
    <table>
        <tr>
            <td width="100">Title</td>
            <td width="400">{{ $abstrak->title }}</td>
        </tr>
        <tr>
            <td>Submited at</td>
            <td>{{ \App\Helpers\AppHelper::parse_date_short($abstrak->created_at) }}</td>
        </tr>
        <tr>
            <td>Accepted at</td>
            <td>{{ \App\Helpers\AppHelper::parse_date_short($abstrak->acc_at) }}</td>
        </tr>
        <tr>
            <td style="vertical-align: top; text-align:left;">Author</td>
            <td>
                @php
                    $no = 1;
                @endphp
                @foreach ($abstrak->penulis as $author)
                    <span>{{ $no++ }}.
                        {{ $author->first_name . ' ' . $author->last_name . ', ' . $author->email . ', ' . $author->affiliate }}
                        @if ($author->coresponding)
                            , Is Coresponding
                        @endif
                    </span> <br>
                @endforeach
            </td>
        </tr>
    </table>

    <h4>Review Abstrak</h4>
    <table>
        <tr>
            <th width="250" class="text-left">Reviewer</th>
            <th width="250" class="text-left">Editor</th>
        </tr>
        <tr>
            <td height="500" style="text-align: left; vertical-align:top;">
                @foreach ($abstrak->revisis as $revisi)
                    @if ($revisi->user->type == \App\Models\User::TYPE_REVIEWER)
                        <div class="row">
                            <div class="column">
                                <small><b>{{ $revisi->user->name }}: </b></small>
                            </div>
                            <div class="column text-right">
                                <small>{{ \App\Helpers\AppHelper::parse_date_short($revisi->created_at) }}</small>
                            </div>
                            <div>
                                <small>{{ strip_tags($revisi->note) }}</small>
                            </div>
                        </div>
                        <hr style="border: 1px solid black;">
                    @endif
                @endforeach
            </td>
            <td style="text-align: left; vertical-align:top;">
                @foreach ($abstrak->revisis as $revisi)
                    @if ($revisi->user->type == \App\Models\User::TYPE_EDITOR)
                        <div class="row">
                            <div class="column">
                                <small><b>{{ $revisi->user->name }}: </b></small>
                            </div>
                            <div class="column text-right">
                                <small>{{ \App\Helpers\AppHelper::parse_date_short($revisi->created_at) }}</small>
                            </div>
                            <div>
                                <small>{{ strip_tags($revisi->note) }}</small>
                            </div>
                        </div>
                        <hr style="border: 1px solid black;">
                    @endif
                @endforeach
            </td>
        </tr>
    </table>
    <h4>Review Paper</h4>
    <table>
        <tr>
            <th width="250" class="text-left">Reviewer</th>
            <th width="250" class="text-left">Editor</th>
        </tr>
        <tr>
            <td height="680" style="text-align: left; vertical-align:top;">
                @foreach ($paper->revisis as $revisi)
                    @if ($revisi->user->type == \App\Models\User::TYPE_REVIEWER)
                        <div class="row">
                            <div class="column">
                                <small>
                                    <b>{{ $revisi->user->name }}: </b> <br>
                                </small>
                            </div>
                            <div class="column text-right">
                                <small>{{ \App\Helpers\AppHelper::parse_date_short($revisi->created_at) }}</small>
                            </div>
                            <div>
                                <small>{!! nl2br($revisi->note) !!}</small>
                            </div>
                        </div>
                        <hr style="border: 1px solid black;">
                    @endif
                @endforeach
            </td>
            <td style="text-align: left; vertical-align:top;">
                @foreach ($paper->revisis as $revisi)
                    @if ($revisi->user->type == \App\Models\User::TYPE_EDITOR)
                        <div class="row">
                            <div class="column">
                                <small><b>{{ $revisi->user->name }}: </b></small>
                            </div>
                            <div class="column text-right">
                                <small>{{ \App\Helpers\AppHelper::parse_date_short($revisi->created_at) }}</small>
                            </div>
                            <div>
                                {{ strip_tags($revisi->note) }}
                            </div>
                        </div>
                        <hr style="border: 1px solid black;">
                    @endif
                @endforeach
            </td>
        </tr>
    </table>
    <h4>Review Video</h4>
    <table>
        <tr>
            <th width="500" class="text-left">Editor</th>
        </tr>
        <tr>
            <td style="text-align: left; vertical-align:top;">
                @if ($video)
                    @if (count($video->revisis) != 0)
                        @foreach ($video->revisis as $revisi)
                            <div class="row">
                                <div class="column">
                                    <small>
                                        <b>{{ $revisi->user->name }}: </b>
                                    </small>
                                </div>
                                <div class="column text-right">
                                    <small>{{ \App\Helpers\AppHelper::parse_date_short($revisi->created_at) }}</small>
                                </div>
                                <div>
                                    <small>{!! nl2br($revisi->note) !!}</small>
                                </div>
                            </div>
                            <hr style="border: 1px solid black;">
                        @endforeach
                    @endif
                @endif
            </td>
        </tr>
    </table>
    Print at: {{ now()->format('d/m/Y H:i A') }}
</body>

</html>
