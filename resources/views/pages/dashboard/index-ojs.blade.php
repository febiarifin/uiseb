@extends('layouts.dashboard')
@section('content')
    <ul class="nav nav-pills mb-3 mt-4" id="pills-tab" role="tablist">
        @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA)
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-registration-tab" data-toggle="pill" data-target="#pills-registration"
                    type="button" role="tab" aria-controls="pills-registration" aria-selected="true">Registration <span
                        class="badge badge-danger">{{ count($registrations) }}</span></button>
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
                    <span class="badge badge-danger">{{ count($abstraks) }}</span>
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
                    <span class="badge badge-danger">{{ count($papers) }}</span>
                @endif
            </button>
        </li>
        @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA ||
                Auth::user()->type == \App\Models\User::TYPE_EDITOR ||
                Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN ||
                Auth::user()->type == \App\Models\User::TYPE_ADMIN)
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-video-tab" data-toggle="pill" data-target="#pills-video" type="button"
                    role="tab" aria-controls="pills-video" aria-selected="true">
                    @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA)
                        Video
                    @else
                        Review Video
                        <span class="badge badge-danger">{{ count($videos) }}</span>
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
                        @if (count($registrations) == 0)
                            <a href="{{ route('registration.list') }}" class="btn btn-primary btn-sm mb-4"><i
                                class="fas fa-plus-circle"></i> New Registration</a>
                        @endif
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
                                        <td>{{ \App\Helpers\AppHelper::currency($registration->category) }}</td>
                                        <td>{{ \App\Helpers\AppHelper::parse_date_short($registration->created_at) }}</td>
                                        <td>{{ $registration->validated_at ? \App\Helpers\AppHelper::parse_date_short($registration->validated_at) : null }}
                                        </td>
                                        <td>
                                            @if ($registration->is_valid == \App\Models\Registration::IS_VALID)
                                                <span class="badge badge-success">PAID</span>
                                            @elseif ($registration->is_valid == \App\Models\Registration::NOT_VALID)
                                                <span class="badge badge-warning">NOT ACCEPTED</span>
                                            @elseif ($registration->payment_image)
                                                <span class="badge badge-secondary">Waiting for Validation</span>
                                            @else
                                                <span class="badge badge-secondary">UNPAID</span>
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                            @if (count(
                                                    $registration->abstraks()->where('status', \App\Models\Abstrak::ACCEPTED)->get()) != 0)
                                                @if ($registration->is_valid == \App\Models\Registration::NOT_VALID || !$registration->payment_image)
                                                    <a href="{{ route('upload.payment', $registration->id) }}"
                                                        class="btn btn-primary btn-sm mr-1"><i class="fas fa-upload"></i>
                                                        Upload Pembayaran</a>
                                                @endif
                                            @endif
                                            @if (!$registration->category->is_paper)
                                                @if ($registration->is_valid == \App\Models\Registration::NOT_VALID || !$registration->payment_image)
                                                    <a href="{{ route('upload.payment', $registration->id) }}"
                                                        class="btn btn-primary btn-sm mr-1"><i class="fas fa-upload"></i>
                                                        Upload Pembayaran</a>
                                                @endif
                                            @endif
                                            @if ($registration->is_valid == \App\Models\Registration::IS_VALID)
                                                <div class="dropdown mr-1">
                                                    <a class="btn btn-secondary btn-sm dropdown-toggle" href="#"
                                                        role="button" data-toggle="dropdown" aria-expanded="false">
                                                        Print
                                                    </a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('print.invoice', base64_encode($registration->id) . uniqid()) }}"
                                                            target="_blank">INVOICE</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('print.loa', [base64_encode($registration->id) . uniqid(), 'loa']) }}"
                                                            target="_blank">LOA Abstrak</a>
                                                            <a class="dropdown-item"
                                                            href="{{ route('print.loa', [base64_encode($registration->id) . uniqid(), 'loa-paper']) }}"
                                                            target="_blank">LOA Paper</a>
                                                        @if ($registration->category->is_paper)
                                                            <a class="dropdown-item"
                                                                href="{{ route('print.review', base64_encode($registration->id) . uniqid()) }}"
                                                                target="_blank">REVIEWS</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('print.symposium', base64_encode($registration->id) . uniqid()) }}"
                                                                target="_blank">SYMPOSIUM</a>
                                                        @endif
                                                        <a class="dropdown-item" href="#"
                                                            target="_blank">CERTIFICATE</a>
                                                    </div>
                                                </div>
                                            @endif
                                            <a href="{{ route('registration.detail', $registration->id) }}"
                                                class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i></a>
                                        </td>
                                    </tr>

                                    @if (count($registration->abstraks) != 0)
                                        <tr bgcolor="#e5a2a2" class="text-white">
                                            <th colspan="3">Abstract</th>
                                            <th>File</th>
                                            <th>Accepeted At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($registration->abstraks as $abstrak)
                                            <tr bgcolor="#f2d3d3">
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
                                                        <span class="badge badge-secondary">Waiting for Review</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (
                                                        $abstrak->status != \App\Models\Abstrak::ACCEPTED &&
                                                            $abstrak->status != \App\Models\Abstrak::REVIEW &&
                                                            $abstrak->status != \App\Models\Abstrak::REJECTED)
                                                        <a href="{{ route('abstraks.edit', $abstrak->id) }}"
                                                            class="btn btn-primary btn-sm mb-2"><i
                                                                class="fas fa-upload"></i>
                                                            Submit Abstrak</a>
                                                    @endif
                                                    {{-- @if ($abstrak->status == \App\Models\Abstrak::ACCEPTED)
                                                        <a href="{{ route('print.review', [base64_encode($abstrak->id), 'abstrak']) }}"
                                                            class="btn btn-secondary btn-sm" target="_blank"><i
                                                                class="fas fa-print"></i>
                                                            Print Review</a>
                                                    @endif --}}
                                                    @if ($abstrak->file)
                                                        <a href="{{ route('abstraks.show', $abstrak->id) }}"
                                                            class="btn btn-info btn-sm "><i
                                                                class="fas fa-info-circle"></i></a>
                                                    @endif
                                                </td>
                                            </tr>

                                            @if (count($abstrak->papers) != 0)
                                                <tr bgcolor="#e5a2b9" class="text-white">
                                                    <th colspan="3">Paper</th>
                                                    <th>File</th>
                                                    <th>Accepeted At</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                @foreach ($abstrak->papers as $paper)
                                                    <tr bgcolor="#e9d1d9">
                                                        <td colspan="3">{{ $abstrak->title }}</td>
                                                        <td>
                                                            @if ($paper->file)
                                                                <a href="{{ asset($paper->file) }}" target="_blank"
                                                                    download><i class="fas fa-download"></i> Download</a>
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
                                                            @elseif ($paper->status == \App\Models\Paper::REVIEW || $paper->status == \App\Models\Paper::REVIEW_EDITOR)
                                                                <span class="badge badge-secondary">Waiting for
                                                                    Review</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (
                                                                $paper->status != \App\Models\Paper::ACCEPTED &&
                                                                    $paper->status != \App\Models\Paper::REVIEW &&
                                                                    $paper->status != \App\Models\Paper::REJECTED &&
                                                                    $paper->status != \App\Models\Paper::REVIEW_EDITOR &&
                                                                    $registration->is_valid == \App\Models\Registration::IS_VALID)
                                                                <a href="{{ route('papers.edit', $paper->id) }}"
                                                                    class="btn btn-primary btn-sm mb-2"><i
                                                                        class="fas fa-upload"></i>
                                                                    Submit Paper</a>
                                                            @endif
                                                            {{-- @if ($paper->status == \App\Models\Paper::ACCEPTED)
                                                                <a href="{{ route('print.review', [base64_encode($paper->id), 'paper']) }}"
                                                                    class="btn btn-secondary btn-sm" target="_blank"><i
                                                                        class="fas fa-print"></i>
                                                                    Print Review</a>
                                                            @endif --}}
                                                            @if ($paper->file)
                                                                <a href="{{ route('papers.show', $paper->id) }}"
                                                                    class="btn btn-info btn-sm "><i
                                                                        class="fas fa-info-circle"></i></a>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    @if ($paper->published_review == \App\Models\Paper::PUBLISHED_REVIEW)
                                                        @if (count($paper->videos) != 0)
                                                            @if ($paper->is_published == \App\Models\Paper::IS_PUBLISHED)
                                                                <tr>
                                                                    <td class="text-center" colspan="7">
                                                                        @if ($setting->confirmation_letter)
                                                                            <a href="{{ asset($setting->confirmation_letter) }}"
                                                                                class="btn btn-secondary btn-sm mr-2"><i
                                                                                    class="fas fa-download"></i>
                                                                                CONFIRMATION LETTER</a>
                                                                        @endif
                                                                        @if ($setting->copyright_letter)
                                                                            <a href="{{ asset($setting->copyright_letter) }}"
                                                                                class="btn btn-secondary btn-sm mr-2"><i
                                                                                    class="fas fa-download"></i> COPYRIGHT
                                                                                LETTER</a>
                                                                        @endif
                                                                        @if ($setting->self_declare_letter)
                                                                            <a href="{{ asset($setting->self_declare_letter) }}"
                                                                                class="btn btn-secondary btn-sm mr-2"><i
                                                                                    class="fas fa-download"></i> SELF
                                                                                DECLARE LETTER</a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            <tr bgcolor="#a2bee5" class="text-white">
                                                                <th colspan="3">Video</th>
                                                                <th>Link Video</th>
                                                                <th>Accepeted At</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            @foreach ($paper->videos as $video)
                                                                <tr bgcolor="#cdd6e4">
                                                                    <td colspan="3">{{ $abstrak->title }}</td>
                                                                    <td>
                                                                        @if ($video->link)
                                                                            <a href="{{ $video->link }}" target="_blank"
                                                                                download><i class="fab fa-youtube"></i>
                                                                                View
                                                                                Video</a>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($video->acc_at)
                                                                            <b>{{ \App\Helpers\AppHelper::parse_date_short($video->acc_at) }}</b>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($video->status == \App\Models\Video::REVISI_MINOR)
                                                                            <span class="badge badge-warning">REVISI
                                                                                MINOR</span>
                                                                        @elseif ($video->status == \App\Models\Video::REVISI_MAYOR)
                                                                            <span class="badge badge-warning">REVISI
                                                                                MAYOR</span>
                                                                        @elseif ($video->status == \App\Models\Video::REJECTED)
                                                                            <span
                                                                                class="badge badge-danger">REJECTED</span>
                                                                        @elseif ($video->status == \App\Models\Video::ACCEPTED)
                                                                            <span
                                                                                class="badge badge-success">ACCEPTED</span>
                                                                        @elseif ($video->status == \App\Models\Video::REVIEW)
                                                                            <span class="badge badge-secondary">Waiting for
                                                                                Review</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if (
                                                                            $video->status != \App\Models\Video::ACCEPTED &&
                                                                                $video->status != \App\Models\Video::REVIEW &&
                                                                                $video->status != \App\Models\Video::REJECTED)
                                                                            <a href="{{ route('videos.edit', $video->id) }}"
                                                                                class="btn btn-primary btn-sm mb-2"><i
                                                                                    class="fas fa-upload"></i>
                                                                                Submit Video</a>
                                                                        @endif
                                                                        @if ($video->link)
                                                                            <a href="{{ route('videos.show', $video->id) }}"
                                                                                class="btn btn-info btn-sm "><i
                                                                                    class="fas fa-info-circle"></i></a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    @elseif($paper->is_published != \App\Models\Paper::IS_PUBLISHED && $paper->status == \App\Models\Paper::ACCEPTED)
                                                        <tr>
                                                            <td colspan="6">
                                                                KONFIRMASI PUBLIKASI PAPER
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('paper.published', $paper->id) }}"
                                                                    class="btn btn-primary"
                                                                    onclick="return confirm('Yakin ingin konfirmasi publikasi paper?')"><i
                                                                        class="fas fa-check-circle"></i> KONFIRMASI</a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
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
                    <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                @if (Auth::user()->type != \App\Models\User::TYPE_PESERTA)
                                    <th>User</th>
                                @endif
                                <th>Title</th>
                                <th>File</th>
                                <th>Accepted At</th>
                                <th>Status</th>
                                <th>Reviewer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                @if (Auth::user()->type != \App\Models\User::TYPE_PESERTA)
                                    <th>User</th>
                                @endif
                                <th>Title</th>
                                <th>File</th>
                                <th>Accepted At</th>
                                <th>Status</th>
                                <th>Reviewer</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER ||
                                    Auth::user()->type == \App\Models\User::TYPE_EDITOR ||
                                    Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN ||
                                    Auth::user()->type == \App\Models\User::TYPE_ADMIN)
                                @foreach ($abstraks as $abstrak)
                                    <tr>
                                        <td><b>{{ $no++ }}</b></td>
                                        @if (Auth::user()->type != \App\Models\User::TYPE_PESERTA)
                                            <td>{{ $abstrak->registration->user->name }}</td>
                                        @endif
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
                                                <span class="badge badge-secondary">Waiting for Review</span>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($abstrak->users as $user)
                                                <span class="p-1 border rounded mr-2">@ {{ $user->name }} </span>
                                            @endforeach
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
                                                    <span class="badge badge-secondary">Waiting for Review</span>
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
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                @if (Auth::user()->type != \App\Models\User::TYPE_PESERTA)
                                    <th>User</th>
                                @endif
                                <th>Title</th>
                                <th>File</th>
                                <th>Accepted At</th>
                                <th>Status</th>
                                <th>Reviewer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                @if (Auth::user()->type != \App\Models\User::TYPE_PESERTA)
                                    <th>User</th>
                                @endif
                                <th>Title</th>
                                <th>File</th>
                                <th>Accepted At</th>
                                <th>Status</th>
                                <th>Reviewer</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER ||
                                    Auth::user()->type == \App\Models\User::TYPE_EDITOR ||
                                    Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN  ||
                                    Auth::user()->type == \App\Models\User::TYPE_ADMIN)
                                @foreach ($papers as $paper)
                                    <tr>
                                        <td><b>{{ $no++ }}</b></td>
                                        @if (Auth::user()->type != \App\Models\User::TYPE_PESERTA)
                                            <td>{{ $paper->abstrak->registration->user->name }}</td>
                                        @endif
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
                                                <span class="badge badge-secondary">Waiting for Review</span>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($paper->users as $user)
                                                <span class="p-1 border rounded mr-2">@ {{ $user->name }} </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('papers.review', $paper->id) }}"
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
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($registrations as $registration)
                                    @foreach ($registration->abstraks()->orderBy('created_at', 'desc')->get() as $abstrak)
                                        @foreach ($abstrak->papers as $paper)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $abstrak->title }}</td>
                                                <td>
                                                    @if ($paper->file)
                                                        <a href="{{ asset($paper->file) }}" target="_blank" download><i
                                                                class="fas fa-download"></i> Download</a>
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
                                                        <span class="badge badge-secondary">Waiting for Review</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (
                                                        $paper->status != \App\Models\Paper::ACCEPTED &&
                                                            $paper->status != \App\Models\Paper::REVIEW &&
                                                            $paper->status != \App\Models\Paper::REJECTED)
                                                        <a href="{{ route('papers.edit', $paper->id) }}"
                                                            class="btn btn-primary btn-sm mb-2"><i
                                                                class="fas fa-upload"></i>
                                                            Submit Paper</a>
                                                    @endif
                                                    @if ($paper->file)
                                                        <a href="{{ route('papers.show', $paper->id) }}"
                                                            class="btn btn-info btn-sm "><i
                                                                class="fas fa-info-circle"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA ||
                Auth::user()->type == \App\Models\User::TYPE_EDITOR ||
                Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN ||
                Auth::user()->type == \App\Models\User::TYPE_ADMIN)
            <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    @if (Auth::user()->type != \App\Models\User::TYPE_PESERTA)
                                        <th>User</th>
                                    @endif
                                    <th>Title</th>
                                    <th>Video Link</th>
                                    <th>Accepted At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    @if (Auth::user()->type != \App\Models\User::TYPE_PESERTA)
                                        <th>User</th>
                                    @endif
                                    <th>Title</th>
                                    <th>Video Link</th>
                                    <th>Accepted At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @if (Auth::user()->type == \App\Models\User::TYPE_EDITOR ||
                                Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN ||
                                Auth::user()->type == \App\Models\User::TYPE_ADMIN)
                                    @foreach ($videos as $video)
                                        <tr>
                                            <td><b>{{ $no++ }}</b></td>
                                            @if (Auth::user()->type != \App\Models\User::TYPE_PESERTA)
                                                <td>{{ $video->paper->abstrak->registration->user->name }}</td>
                                            @endif
                                            <td><b>{{ $video->paper->abstrak->title }}</b></td>
                                            <td>
                                                @if ($video->link)
                                                    <a href="{{ $video->link }}" target="_blank"><i
                                                            class="fab fa-youtube"></i>
                                                        View
                                                        Video</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($video->acc_at)
                                                    <b>{{ \App\Helpers\AppHelper::parse_date_short($video->acc_at) }}</b>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($video->status == \App\Models\Video::REVISI_MINOR)
                                                    <span class="badge badge-warning">REVISI MINOR</span>
                                                @elseif ($video->status == \App\Models\Video::REVISI_MAYOR)
                                                    <span class="badge badge-warning">REVISI MAYOR</span>
                                                @elseif ($video->status == \App\Models\Video::REJECTED)
                                                    <span class="badge badge-danger">REJECTED</span>
                                                @elseif ($video->status == \App\Models\Video::ACCEPTED)
                                                    <span class="badge badge-success">ACCEPTED</span>
                                                @elseif ($video->status == \App\Models\Video::REVIEW)
                                                    <span class="badge badge-secondary">Waiting for Review</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('videos.review', $video->id) }}"
                                                    class="btn btn-info btn-sm ">
                                                    <i class="fas fa-check-circle"></i> Review
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
                                            @foreach ($abstrak->papers as $paper)
                                                @foreach ($paper->videos as $video)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $abstrak->title }}</td>
                                                        <td>
                                                            @if ($video->link)
                                                                <a href="{{ $video->link }}" target="_blank">
                                                                    <i class="fab fa-youtube"></i> View Video</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($video->acc_at)
                                                                <b>{{ \App\Helpers\AppHelper::parse_date_short($video->acc_at) }}</b>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($video->status == \App\Models\Paper::REVISI_MINOR)
                                                                <span class="badge badge-warning">REVISI MINOR</span>
                                                            @elseif ($video->status == \App\Models\Paper::REVISI_MAYOR)
                                                                <span class="badge badge-warning">REVISI MAYOR</span>
                                                            @elseif ($video->status == \App\Models\Paper::REJECTED)
                                                                <span class="badge badge-danger">REJECTED</span>
                                                            @elseif ($video->status == \App\Models\Paper::ACCEPTED)
                                                                <span class="badge badge-success">ACCEPTED</span>
                                                            @elseif ($video->status == \App\Models\Paper::REVIEW)
                                                                <span class="badge badge-secondary">Waiting for
                                                                    Review</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (
                                                                $video->status != \App\Models\Paper::ACCEPTED &&
                                                                    $video->status != \App\Models\Paper::REVIEW &&
                                                                    $video->status != \App\Models\Paper::REJECTED)
                                                                <a href="{{ route('videos.edit', $video->id) }}"
                                                                    class="btn btn-primary btn-sm mb-2"><i
                                                                        class="fas fa-upload"></i>
                                                                    Submit Video</a>
                                                            @endif
                                                            @if ($video->link)
                                                                <a href="{{ route('videos.show', $video->id) }}"
                                                                    class="btn btn-info btn-sm "><i
                                                                        class="fas fa-info-circle"></i></a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
