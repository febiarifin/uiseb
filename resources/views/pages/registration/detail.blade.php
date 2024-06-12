@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-shrink-0">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>
        <div class="card-body">
            @if ($registration->is_valid == \App\Models\Registration::IS_VALID)
                <div class="alert alert-success"><i class="fas fa-info-circle"></i> Congratulations, your registration has
                    been validated!</div>
            @elseif ($registration->note)
                <div class="alert alert-warning"><i class="fas fa-info-circle"></i> {{ $registration->note }}</div>
            @endif
            @if (Auth::user()->type == \App\Models\User::TYPE_PESERTA && $registration->paper)
                @if ($registration->status == \App\Models\Registration::ACC)
                    <div class="alert alert-success"><i class="fas fa-info-circle"></i> Congratulations, your paper has been
                        ACC!</div>
                @elseif($registration->status == \App\Models\Registration::REVISI)
                    <div class="alert alert-warning"><i class="fas fa-info-circle"></i> Your paper has been REVISI. Resubmit
                        immediately!</div>
                @elseif($registration->status == \App\Models\Registration::REVIEW)
                    <div class="alert alert-secondary"><i class="fas fa-info-circle"></i> Your paper has been REVIEW. Wait
                        for
                        the review!</div>
                @endif
            @endif
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ $registration->user->name }}" disabled>
                </div>
                <div class="mb-3 col-md-6">
                    <label>Email</label>
                    <input type="text" class="form-control" value="{{ $registration->user->email }}" disabled>
                </div>
                <div class="mb-3 col-md-6">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" value="{{ $registration->user->phone_number }}" disabled>
                </div>
                <div class="mb-3 col-md-6">
                    <label>Institution</label>
                    <input type="text" class="form-control" value="{{ $registration->user->institution }}" disabled>
                </div>
                <div class="mb-3 col-md-6">
                    <label>Position</label>
                    <input type="text" class="form-control" value="{{ $registration->user->position }}" disabled>
                </div>
                <div class="mb-3 col-md-6">
                    <label>Subject Background</label>
                    <input type="text" class="form-control" value="{{ $registration->user->subject_background }}"
                        disabled>
                </div>
                <div class="mb-3 col-md-10">
                    <label>Category</label>
                    <input type="text" class="form-control" value="{{ $registration->category->is_paper ? $registration->category->name.' + PAPER' : $registration->category->name }}" disabled>
                </div>
                <div class="mb-3 col-md-2">
                    <label>Fee</label>
                    <input type="text" class="form-control"
                        value="{{ \App\Helpers\AppHelper::currency($registration->category->amount) }}" disabled>
                </div>
            </div>
            @if ($type == 'review' || $type == 'detail')
                @if ($registration->paper)
                    <div class="mb-3">
                        <label>Paper:
                            <b><a href="{{ asset($registration->paper) }}" target="_blank"> <i class="fas fa-download"></i>
                                    Download</a></b>
                        </label>
                    </div>
                @endif
            @endif
            @if ($type == 'validate' || $type == 'detail')
                @if ($registration->payment_image)
                    <div class="mb-3">
                        <label>Payment:
                            <br>
                            <a href="{{ asset($registration->payment_image) }}" target="_blank">
                                <img src="{{ asset($registration->payment_image) }}" width="100" class="shadow border">
                            </a>
                        </label>
                    </div>
                @endif
            @endif

            @if ($type == 'validate' || $type == 'review')
                @if ($registration->is_valid != \App\Models\Registration::IS_VALID)
                    <a class="btn btn-success shadow" href="#" data-toggle="modal" data-target="#accModal">
                        <i class="fas fa-check-circle"></i>
                        Acc @if ($type == 'validate')
                            Pendaftaran
                        @endif
                    </a>
                    <a class="btn btn-primary shadow" href="#" data-toggle="modal" data-target="#revisiModal">
                        <i class="fas fa-edit"></i>
                        Revisi @if ($type == 'validate')
                            Pendaftaran
                        @endif
                    </a>
                @endif
            @endif
        </div>
    </div>

    @if ($type == 'review' || ($type == 'detail' && count($registration->revisions) != 0))
        <div class="card shadow mb-4">
            <div class="card-header">
                Revisi <span class="badge badge-danger">{{ count($registration->revisions) }}</span>
            </div>
            <div class="card-body">
                @foreach ($registration->revisions as $revision)
                    <div class="border shadow rounded p-2 mb-2">
                        <small class="text-muted">{{ \App\Helpers\AppHelper::parse_date($revision->created_at) }}</small>
                        <br>
                        <span class="text-dark">{{ $revision->note }}</span>
                        <br>
                        <small>Attachment: <a href="{{ asset($revision->attachment) }}" target="_blank"> <i
                                    class="fas fa-download"></i>
                                Download</a></b></small>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Acc Modal-->
    <div class="modal fade" id="accModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Acc @if ($type == 'validate')
                            Pendaftaran
                        @endif
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Konfirmasi Acc @if ($type == 'validate')
                        Pendaftaran
                    @else
                        Paper
                    @endif Peserta?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary"
                        href="{{ $type == 'validate' ? route('registration.acc', $registration->id) : route('registration.paper.acc', $registration->id) }}"><i
                            class="fas fa-check-circle"></i>
                        Kofirmasi</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Revisi Modal-->
    <div class="modal fade" id="revisiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Revisi @if ($type == 'validate')
                            Pendaftaran
                        @endif
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form
                    action="{{ $type == 'validate' ? route('registration.revisi', $registration->id) : route('registration.paper.revisi', $registration->id) }}"
                    method="post">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div>
                            <label>Catatan</label>
                            <textarea class="form-control" name="note" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-check-circle"></i>
                            Kofirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
