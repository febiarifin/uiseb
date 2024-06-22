@extends('layouts.dashboard')
@section('content')
    <ul class="nav nav-pills mb-3 mt-4" id="pills-tab" role="tablist">
        @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA)
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-registration-tab" data-toggle="pill" data-target="#pills-registration"
                    type="button" role="tab" aria-controls="pills-registration"
                    aria-selected="true">Registration</button>
            </li>
        @endif
        <li class="nav-item" role="presentation">
            <button class="nav-link @if (Auth::user()->type != \App\Models\User::TYPE_PESERTA) active @endif" id="pills-abstrak-tab"
                data-toggle="pill" data-target="#pills-abstrak" type="button" role="tab" aria-controls="pills-abstrak"
                aria-selected="false">
                @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA)
                    Abstrak
                @else
                    Review Abstrak
                @endif
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-paper-tab" data-toggle="pill" data-target="#pills-paper" type="button"
                role="tab" aria-controls="pills-paper" aria-selected="false">
                @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA)
                    Paper
                @else
                    Review Paper
                @endif
            </button>
        </li>
        @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA || Auth::user()->type == \App\Models\User::TYPE_EDITOR)
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-video-tab" data-toggle="pill" data-target="#pills-video" type="button"
                    role="tab" aria-controls="pills-video" aria-selected="true">
                    @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA)
                        Video
                    @else
                        Review Video
                    @endif
                </button>
            </li>
        @endif
    </ul>
    <div class="tab-content" id="pills-tabContent">
        @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA)
            <div class="tab-pane fade show active" id="pills-registration" role="tabpanel"
                aria-labelledby="pills-registration-tab">
                <div class="card">
                    <div class="table-responsive card-body">
                        <a href="{{ route('registration.list') }}" class="btn btn-primary btn-sm mb-4"><i
                                class="fas fa-plus-circle"></i> New
                            Registration</a>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Fee</th>
                                    <th>Registration At</th>
                                    <th>Accepted At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Fee</th>
                                    <th>Registration At</th>
                                    <th>Accepted At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($registrations as $registration)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $registration->category->name }}
                                            @if ($registration->category->is_paper)
                                                <span class="badge badge-secondary">+ PAPER</span>
                                            @endif
                                        </td>
                                        <td>{{ \App\Helpers\AppHelper::currency($registration->category->amount) }}</td>
                                        <td>{{ \App\Helpers\AppHelper::parse_date_short($registration->created_at) }}</td>
                                        <td>{{ $registration->validated_at ? \App\Helpers\AppHelper::parse_date_short($registration->validated_at) : null }}
                                        </td>
                                        <td>
                                            @if ($registration->is_valid == \App\Models\Registration::IS_VALID)
                                                <span class="badge badge-success">ACCEPTED</span>
                                            @elseif ($registration->is_valid == \App\Models\Registration::NOT_VALID)
                                                <span class="badge badge-warning">NOT ACCEPTED</span>
                                            @elseif ($registration->payment_image)
                                                <span class="badge badge-secondary">REVIEW</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (count(
                                                    $registration->abstraks()->where('status', \App\Models\Abstrak::ACCEPTED)->get()) != 0)
                                                @if ($registration->is_valid == \App\Models\Registration::IS_VALID)
                                                    {{-- <a href="{{ route('papers.edit',$registration->abstraks()->where('status', \App\Models\Abstrak::ACCEPTED)->first()->id) }}"
                                                        class="btn btn-primary btn-sm mt-2"><i class="fas fa-upload"></i>
                                                        Submit Paper</a> --}}
                                                @elseif ($registration->is_valid == \App\Models\Registration::NOT_VALID || !$registration->payment_image)
                                                    <a href="{{ route('upload.payment', $registration->id) }}"
                                                        class="btn btn-primary btn-sm mt-2"><i class="fas fa-upload"></i>
                                                        Upload Pembayaran</a>
                                                @endif
                                            @endif
                                            @if (!$registration->category->is_paper)
                                                @if ($registration->is_valid == \App\Models\Registration::NOT_VALID || !$registration->payment_image)
                                                    <a href="{{ route('upload.payment', $registration->id) }}"
                                                        class="btn btn-primary btn-sm mt-2"><i class="fas fa-upload"></i>
                                                        Upload Pembayaran</a>
                                                @endif
                                            @endif
                                            <a href="{{ route('registration.detail', $registration->id) }}"
                                                class="btn btn-info btn-sm mt-2"><i class="fas fa-info-circle"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Judul Abstrak</th>
                                        <th>File</th>
                                        <th>Accepeted At</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($registration->abstraks as $abstrak)
                                        <tr>
                                            <td colspan="3">{{ $abstrak->title }}</td>
                                            <td>
                                                @if ($abstrak->file)
                                                    <a href="{{ asset($abstrak->file) }}" target="_blank" download><i
                                                            class="fas fa-download"></i> Download</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($abstrak->acc_at)
                                                    <b>{{ \App\Helpers\AppHelper::parse_date_short($abstrak->acc_at) }}</b>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($abstrak->status == \App\Models\Abstrak::REVISI_MINOR)
                                                    <span class="badge badge-warning">REVISI MINOR</span>
                                                @elseif ($abstrak->status == \App\Models\Abstrak::REVISI_MAYOR)
                                                    <span class="badge badge-warning">REVISI MAYOR</span>
                                                @elseif ($abstrak->status == \App\Models\Abstrak::REJECTED)
                                                    <span class="badge badge-danger">REJECTED</span>
                                                @elseif ($abstrak->status == \App\Models\Abstrak::ACCEPTED)
                                                    <span class="badge badge-success">ACCEPTED</span>
                                                @elseif ($abstrak->status == \App\Models\Abstrak::REVIEW)
                                                    <span class="badge badge-secondary">REVIEW</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (
                                                    $abstrak->status != \App\Models\Abstrak::ACCEPTED &&
                                                        $abstrak->status != \App\Models\Abstrak::REVIEW &&
                                                        $abstrak->status != \App\Models\Abstrak::REJECTED)
                                                    <a href="{{ route('abstraks.edit', $abstrak->id) }}"
                                                        class="btn btn-primary btn-sm mb-2"><i class="fas fa-upload"></i>
                                                        Submit Abstrak</a>
                                                @endif
                                                @if ($abstrak->file)
                                                    <a href="{{ route('abstraks.show', $abstrak->id) }}"
                                                        class="btn btn-info btn-sm "><i class="fas fa-info-circle"></i></a>
                                                @endif
                                            </td>
                                        </tr>

                                        @if ($abstrak->paper)
                                            <tr>
                                                <th colspan="3">Judul Paper</th>
                                                <th>File</th>
                                                <th>Accepeted At</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            <tr>
                                                <td colspan="3">{{ $abstrak->title }}</td>
                                                <td>
                                                    @if ($abstrak->paper->file)
                                                        <a href="{{ asset($abstrak->paper->file) }}" target="_blank"
                                                            download><i class="fas fa-download"></i> Download</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($abstrak->paper->acc_at)
                                                        <b>{{ \App\Helpers\AppHelper::parse_date_short($abstrak->paper->acc_at) }}</b>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($abstrak->paper->status == \App\Models\Paper::REVISI_MINOR)
                                                        <span class="badge badge-warning">REVISI MINOR</span>
                                                    @elseif ($abstrak->paper->status == \App\Models\Paper::REVISI_MAYOR)
                                                        <span class="badge badge-warning">REVISI MAYOR</span>
                                                    @elseif ($abstrak->paper->status == \App\Models\Paper::REJECTED)
                                                        <span class="badge badge-danger">REJECTED</span>
                                                    @elseif ($abstrak->paper->status == \App\Models\Paper::ACCEPTED)
                                                        <span class="badge badge-success">ACCEPTED</span>
                                                    @elseif ($abstrak->paper->status == \App\Models\Paper::REVIEW)
                                                        <span class="badge badge-secondary">REVIEW</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (
                                                        $abstrak->paper->status != \App\Models\Paper::ACCEPTED &&
                                                            $abstrak->paper->status != \App\Models\Paper::REVIEW &&
                                                            $abstrak->paper->status != \App\Models\Paper::REJECTED)
                                                        <a href="{{ route('papers.edit', $abstrak->paper->id) }}"
                                                            class="btn btn-primary btn-sm mb-2"><i
                                                                class="fas fa-upload"></i>
                                                            Submit Paper</a>
                                                    @endif
                                                    @if ($abstrak->paper->file)
                                                        <a href="{{ route('papers.show', $abstrak->paper->id) }}"
                                                            class="btn btn-info btn-sm "><i
                                                                class="fas fa-info-circle"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif

                                        @if ($abstrak->paper->video)
                                            <tr>
                                                <th colspan="3">Judul Paper</th>
                                                <th>Video</th>
                                                <th>Accepeted At</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            <tr>
                                                <td colspan="3">{{ $abstrak->title }}</td>
                                                <td>
                                                    @if ($abstrak->paper->video->file)
                                                        <a href="{{ asset($abstrak->paper->video->file) }}" target="_blank"
                                                            download><i class="fas fa-download"></i> Download</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($abstrak->paper->video->acc_at)
                                                        <b>{{ \App\Helpers\AppHelper::parse_date_short($abstrak->paper->video->acc_at) }}</b>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($abstrak->paper->video->status == \App\Models\Video::REVISI_MINOR)
                                                        <span class="badge badge-warning">REVISI MINOR</span>
                                                    @elseif ($abstrak->paper->video->status == \App\Models\Video::REVISI_MAYOR)
                                                        <span class="badge badge-warning">REVISI MAYOR</span>
                                                    @elseif ($abstrak->paper->video->status == \App\Models\Video::REJECTED)
                                                        <span class="badge badge-danger">REJECTED</span>
                                                    @elseif ($abstrak->paper->video->status == \App\Models\Video::ACCEPTED)
                                                        <span class="badge badge-success">ACCEPTED</span>
                                                    @elseif ($abstrak->paper->video->status == \App\Models\Video::REVIEW)
                                                        <span class="badge badge-secondary">REVIEW</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (
                                                        $abstrak->paper->video->status != \App\Models\Video::ACCEPTED &&
                                                            $abstrak->paper->video->status != \App\Models\Video::REVIEW &&
                                                            $abstrak->paper->video->status != \App\Models\Video::REJECTED)
                                                        <a href="{{ route('videos.edit', $abstrak->paper->video->id) }}"
                                                            class="btn btn-primary btn-sm mb-2"><i
                                                                class="fas fa-upload"></i>
                                                            Submit Video</a>
                                                    @endif
                                                    @if ($abstrak->paper->video->file)
                                                        <a href="{{ route('videos.show', $abstrak->paper->video->id) }}"
                                                            class="btn btn-info btn-sm "><i
                                                                class="fas fa-info-circle"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        <div class="tab-pane fade @if (Auth::user()->type != \App\Models\User::TYPE_PESERTA) show active @endif" id="pills-abstrak"
            role="tabpanel" aria-labelledby="pills-abstrak-tab">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>File</th>
                                <th>Accepted At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>File</th>
                                <th>Accepted At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER || Auth::user()->type == \App\Models\User::TYPE_EDITOR)
                                @foreach ($abstraks as $abstrak)
                                    <tr>
                                        <td><b>{{ $no++ }}</b></td>
                                        <td><b>{{ $abstrak->title }}</b></td>
                                        <td>
                                            @if ($abstrak->file)
                                                <a href="{{ asset($abstrak->file) }}" target="_blank" download><i
                                                        class="fas fa-download"></i> Lampiran</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($abstrak->acc_at)
                                                <b>{{ \App\Helpers\AppHelper::parse_date_short($abstrak->acc_at) }}</b>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($abstrak->status == \App\Models\Abstrak::REVISI_MINOR)
                                                <span class="badge badge-warning">REVISI MINOR</span>
                                            @elseif ($abstrak->status == \App\Models\Abstrak::REVISI_MAYOR)
                                                <span class="badge badge-warning">REVISI MAYOR</span>
                                            @elseif ($abstrak->status == \App\Models\Abstrak::REJECTED)
                                                <span class="badge badge-danger">REJECTED</span>
                                            @elseif ($abstrak->status == \App\Models\Abstrak::ACCEPTED)
                                                <span class="badge badge-success">ACCEPTED</span>
                                            @elseif ($abstrak->status == \App\Models\Abstrak::REVIEW)
                                                <span class="badge badge-secondary">REVIEW</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('abstraks.review', $abstrak->id) }}"
                                                class="btn btn-info btn-sm ">
                                                @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER)
                                                    <i class="fas fa-check-circle"></i> Review
                                                @else
                                                    <i class="fas fa-info-circle"></i>
                                                @endif
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach ($registrations as $registration)
                                    @foreach ($registration->abstraks()->orderBy('created_at', 'desc')->get() as $abstrak)
                                        <tr>
                                            <td><b>{{ $no++ }}</b></td>
                                            <td><b>{{ $abstrak->title }}</b></td>
                                            <td>
                                                @if ($abstrak->file)
                                                    <a href="{{ asset($abstrak->file) }}" target="_blank" download><i
                                                            class="fas fa-download"></i> Lampiran</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($abstrak->acc_at)
                                                    <b>{{ \App\Helpers\AppHelper::parse_date_short($abstrak->acc_at) }}</b>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($abstrak->status == \App\Models\Abstrak::REVISI_MINOR)
                                                    <span class="badge badge-warning">REVISI MINOR</span>
                                                @elseif ($abstrak->status == \App\Models\Abstrak::REVISI_MAYOR)
                                                    <span class="badge badge-warning">REVISI MAYOR</span>
                                                @elseif ($abstrak->status == \App\Models\Abstrak::REJECTED)
                                                    <span class="badge badge-danger">REJECTED</span>
                                                @elseif ($abstrak->status == \App\Models\Abstrak::ACCEPTED)
                                                    <span class="badge badge-success">ACCEPTED</span>
                                                @elseif ($abstrak->status == \App\Models\Abstrak::REVIEW)
                                                    <span class="badge badge-secondary">REVIEW</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (
                                                    $abstrak->status != \App\Models\Abstrak::ACCEPTED &&
                                                        $abstrak->status != \App\Models\Abstrak::REVIEW &&
                                                        $abstrak->status != \App\Models\Abstrak::REJECTED)
                                                    <a href="{{ route('abstraks.edit', $abstrak->id) }}"
                                                        class="btn btn-primary btn-sm mb-2"><i class="fas fa-upload"></i>
                                                        Submit Abstrak</a>
                                                @endif
                                                @if ($abstrak->file)
                                                    <a href="{{ route('abstraks.show', $abstrak->id) }}"
                                                        class="btn btn-info btn-sm "><i
                                                            class="fas fa-info-circle"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-paper" role="tabpanel" aria-labelledby="pills-paper-tab">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>File</th>
                        <th>Accepted At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>File</th>
                        <th>Accepted At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER || Auth::user()->type == \App\Models\User::TYPE_EDITOR)
                        @foreach ($papers as $paper)
                            <tr>
                                <td><b>{{ $no++ }}</b></td>
                                <td><b>{{ $paper->abstrak->title }}</b></td>
                                <td>
                                    @if ($paper->file)
                                        <a href="{{ asset($paper->file) }}" target="_blank" download><i
                                                class="fas fa-download"></i> Lampiran</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($paper->acc_at)
                                        <b>{{ \App\Helpers\AppHelper::parse_date_short($paper->acc_at) }}</b>
                                    @endif
                                </td>
                                <td>
                                    @if ($paper->status == \App\Models\Paper::REVISI_MINOR)
                                        <span class="badge badge-warning">REVISI MINOR</span>
                                    @elseif ($paper->status == \App\Models\Paper::REVISI_MAYOR)
                                        <span class="badge badge-warning">REVISI MAYOR</span>
                                    @elseif ($paper->status == \App\Models\Paper::REJECTED)
                                        <span class="badge badge-danger">REJECTED</span>
                                    @elseif ($paper->status == \App\Models\Paper::ACCEPTED)
                                        <span class="badge badge-success">ACCEPTED</span>
                                    @elseif ($paper->status == \App\Models\Paper::REVIEW)
                                        <span class="badge badge-secondary">REVIEW</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('papers.review', $paper->id) }}" class="btn btn-info btn-sm ">
                                        @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER)
                                            <i class="fas fa-check-circle"></i> Review
                                        @else
                                            <i class="fas fa-info-circle"></i>
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($registrations as $registration)
                            @foreach ($registration->abstraks()->orderBy('created_at', 'desc')->get() as $abstrak)
                                @if ($abstrak->paper)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $abstrak->title }}</td>
                                        <td>
                                            @if ($abstrak->paper->file)
                                                <a href="{{ asset($abstrak->paper->file) }}" target="_blank" download><i
                                                        class="fas fa-download"></i> Download</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($abstrak->paper->acc_at)
                                                <b>{{ \App\Helpers\AppHelper::parse_date_short($abstrak->paper->acc_at) }}</b>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($abstrak->paper->status == \App\Models\Paper::REVISI_MINOR)
                                                <span class="badge badge-warning">REVISI MINOR</span>
                                            @elseif ($abstrak->paper->status == \App\Models\Paper::REVISI_MAYOR)
                                                <span class="badge badge-warning">REVISI MAYOR</span>
                                            @elseif ($abstrak->paper->status == \App\Models\Paper::REJECTED)
                                                <span class="badge badge-danger">REJECTED</span>
                                            @elseif ($abstrak->paper->status == \App\Models\Paper::ACCEPTED)
                                                <span class="badge badge-success">ACCEPTED</span>
                                            @elseif ($abstrak->paper->status == \App\Models\Paper::REVIEW)
                                                <span class="badge badge-secondary">REVIEW</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (
                                                $abstrak->paper->status != \App\Models\Paper::ACCEPTED &&
                                                    $abstrak->paper->status != \App\Models\Paper::REVIEW &&
                                                    $abstrak->paper->status != \App\Models\Paper::REJECTED)
                                                <a href="{{ route('papers.edit', $abstrak->paper->id) }}"
                                                    class="btn btn-primary btn-sm mb-2"><i class="fas fa-upload"></i>
                                                    Submit Paper</a>
                                            @endif
                                            @if ($abstrak->paper->file)
                                                <a href="{{ route('papers.show', $abstrak->paper->id) }}"
                                                    class="btn btn-info btn-sm "><i class="fas fa-info-circle"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Video</th>
                        <th>Accepted At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Video</th>
                        <th>Accepted At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @if (Auth::user()->type == \App\Models\User::TYPE_EDITOR)
                        @foreach ($papers as $paper)
                            <tr>
                                <td><b>{{ $no++ }}</b></td>
                                <td><b>{{ $paper->abstrak->title }}</b></td>
                                <td>
                                    @if ($paper->file)
                                        <a href="{{ asset($paper->file) }}" target="_blank" download><i
                                                class="fas fa-download"></i> Lampiran</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($paper->acc_at)
                                        <b>{{ \App\Helpers\AppHelper::parse_date_short($paper->acc_at) }}</b>
                                    @endif
                                </td>
                                <td>
                                    @if ($paper->status == \App\Models\Paper::REVISI_MINOR)
                                        <span class="badge badge-warning">REVISI MINOR</span>
                                    @elseif ($paper->status == \App\Models\Paper::REVISI_MAYOR)
                                        <span class="badge badge-warning">REVISI MAYOR</span>
                                    @elseif ($paper->status == \App\Models\Paper::REJECTED)
                                        <span class="badge badge-danger">REJECTED</span>
                                    @elseif ($paper->status == \App\Models\Paper::ACCEPTED)
                                        <span class="badge badge-success">ACCEPTED</span>
                                    @elseif ($paper->status == \App\Models\Paper::REVIEW)
                                        <span class="badge badge-secondary">REVIEW</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('papers.review', $paper->id) }}" class="btn btn-info btn-sm ">
                                        @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER)
                                            <i class="fas fa-check-circle"></i> Review
                                        @else
                                            <i class="fas fa-info-circle"></i>
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @elseif (Auth::user()->type == \App\Models\User::TYPE_PESERTA)
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($registrations as $registration)
                            @foreach ($registration->abstraks()->orderBy('created_at', 'desc')->get() as $abstrak)
                                @if ($abstrak->paper->video)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $abstrak->title }}</td>
                                        <td>
                                            @if ($abstrak->paper->video->link)
                                                <a href="{{ asset($abstrak->paper->video->link) }}" target="_blank">
                                                    <i class="fas fa-arrow-up-right-from-square"></i> View Video</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($abstrak->paper->video->acc_at)
                                                <b>{{ \App\Helpers\AppHelper::parse_date_short($abstrak->paper->acc_at) }}</b>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($abstrak->paper->video->status == \App\Models\Paper::REVISI_MINOR)
                                                <span class="badge badge-warning">REVISI MINOR</span>
                                            @elseif ($abstrak->paper->video->status == \App\Models\Paper::REVISI_MAYOR)
                                                <span class="badge badge-warning">REVISI MAYOR</span>
                                            @elseif ($abstrak->paper->video->status == \App\Models\Paper::REJECTED)
                                                <span class="badge badge-danger">REJECTED</span>
                                            @elseif ($abstrak->paper->video->status == \App\Models\Paper::ACCEPTED)
                                                <span class="badge badge-success">ACCEPTED</span>
                                            @elseif ($abstrak->paper->video->status == \App\Models\Paper::REVIEW)
                                                <span class="badge badge-secondary">REVIEW</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (
                                                $abstrak->paper->video->status != \App\Models\Paper::ACCEPTED &&
                                                    $abstrak->paper->video->status != \App\Models\Paper::REVIEW &&
                                                    $abstrak->paper->video->status != \App\Models\Paper::REJECTED)
                                                <a href="{{ route('videos.edit', $abstrak->paper->video->id) }}"
                                                    class="btn btn-primary btn-sm mb-2"><i class="fas fa-upload"></i>
                                                    Submit Paper</a>
                                            @endif
                                            @if ($abstrak->paper->video->file)
                                                <a href="{{ route('videos.show', $abstrak->paper->video->id) }}"
                                                    class="btn btn-info btn-sm "><i class="fas fa-info-circle"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
