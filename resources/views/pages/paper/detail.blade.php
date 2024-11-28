@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-grow-1">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
            <div class="flex-shrink-0">
                @if ($paper->status == \App\Models\Paper::REVISI_MINOR)
                    <span class="badge badge-warning">REVISI MINOR</span>
                @elseif ($paper->status == \App\Models\Paper::REVISI_MAYOR)
                    <span class="badge badge-warning">REVISI MAYOR</span>
                @elseif ($paper->status == \App\Models\Paper::REJECTED)
                    <span class="badge badge-danger">REJECTED</span>
                @elseif ($paper->status == \App\Models\Paper::ACCEPTED)
                    <span class="badge badge-success">ACCEPTED</span>
                @elseif ($paper->status == \App\Models\Paper::REVIEW || $paper->status == \App\Models\Paper::REVIEW_EDITOR)
                    <span class="badge badge-secondary">REVIEW</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" class="form-control" value="{{ $paper->abstrak->title }}" name="title" disabled>
            </div>
            <div class="mb-3">
                <label>Author</label>
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Depan</th>
                        <th>Nama Tengah</th>
                        <th>Nama Belakang</th>
                        <th>Email</th>
                        <th>Afiliasi</th>
                        <th>Degree</th>
                        <th>Address</th>
                        <th>Research Interest</th>
                        <th>Coresponding</th>
                    </tr>
                    @foreach ($paper->abstrak->penulis as $author)
                        <tr>
                            <td>{{ $author->first_name }}</td>
                            <td>{{ $author->middle_name }}</td>
                            <td>{{ $author->last_name }}</td>
                            <td>{{ $author->email }}</td>
                            <td>{{ $author->affiliate }}</td>
                            <td>{{ $author->degree }}</td>
                            <td>{{ $author->address }}</td>
                            <td>{{ $author->research_interest }}</td>
                            <td>
                                @if ($author->coresponding)
                                    <span class="badge badge-light"><i class="fas fa-check-circle"></i> Sebagai
                                        Coresponding</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="mb-3">
                <label>Abstrak</label>
                <div class="p-2 rounded border">
                    {!! nl2br($paper->abstrak->abstract) !!}
                </div>
            </div>
            <div class="mb-3">
                <label>Daftar Pustakan</label>
                <div class="p-2 rounded border">
                    {!! nl2br($paper->bibliography) !!}
                </div>
            </div>
            <div class="mb-3">
                <label>Keyword</label>
                <br>
                @php
                    $keywords = explode(',', $paper->abstrak->keyword);
                @endphp
                @foreach ($keywords as $keyword)
                    <span class="badge badge-info mr-1">{{ $keyword }}</span>
                @endforeach
            </div>
            <div class="mb-3">
                <label>Reviewer</label>
                <br>
                @foreach ($paper->users as $user)
                    <span class="p-1 border rounded mr-2">@ {{ $user->name }}
                        @if (Auth::user()->type == \App\Models\User::TYPE_EDITOR)
                            <a href="{{ route('papers.reviewer.delete', $user->pivot->id) }}" class="btn btn-light btn-sm"
                                onclick="return confirm('Yakin ingin hapus reviewer?')"><i class="fas fa-trash"></i></a>
                        @endif
                    </span>
                @endforeach
                @if (Auth::user()->type == \App\Models\User::TYPE_EDITOR)
                    <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#addReviewerModal">
                        <i class="fas fa-plus-circle"></i> Add Reviewer
                    </a>
                    <!-- Add Reviewer Modal-->
                    <div class="modal fade" id="addReviewerModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Reviewer</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="{{ route('papers.reviewer.store', $paper->id) }}" method="post">
                                    @method('put')
                                    @csrf
                                    <div class="modal-body">
                                        <div>
                                            <label>Pilih Reviewer</label>
                                            <select class="js-example-basic-multiple" name="users[]" multiple="multiple"
                                                style="width: 100%;" required>
                                                @foreach ($reviewers as $reviewer)
                                                    <option value="{{ $reviewer->id }}">{{ $reviewer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            @if ($paper->acc_at)
                <div class="mb-3">
                    <label><i class="fas fa-calendar"></i> Accepted At</label>
                    <b class="text-success">{{ \App\Helpers\AppHelper::parse_date_short($paper->acc_at) }}</b>
                </div>
            @endif
            <div class="mb-3">
                <a class="btn btn-secondary btn-sm shadow" href="{{ route('print.loa', [base64_encode($paper->abstrak->registration->id), 'agreement']) }}" target="_blank">
                    <i class="fas fa-download"></i> COPYRIGHT TRANSFER AGREEMENT FORM UISEB
                </a>
                <a class="btn btn-secondary btn-sm shadow" href="{{ route('print.loa', [base64_encode($paper->abstrak->registration->id), 'submission']) }}" target="_blank">
                    <i class="fas fa-download"></i> SUBMISSION DECLARATION FORM
                </a>
            </div>
            <div class="mb-3">
                <label>Lampiran</label>
                @if ($paper->file)
                    <iframe src="https://docs.google.com/gview?url={{ asset($paper->file) }}&embedded=true"
                        style="width:100%; height:500px;"></iframe>
                    <a href="{{ asset($paper->file) }}" target="_blank" download><i class="fas fa-download"></i>
                        Download Lampiran</a>
                @endif
            </div>
            @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER || Auth::user()->type == \App\Models\User::TYPE_EDITOR)
                <div class="mt-4">
                    @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER)
                        @if ($paper->status == \App\Models\Paper::REVIEW)
                            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#reviewModal">
                                <i class="fas fa-edit"></i> Review Paper
                            </a>
                        @endif
                    @else
                        <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#reviewModal">
                            <i class="fas fa-edit"></i> Hasil Turnitin
                        </a>
                    @endif

                    <!-- Revisi Paper Modal-->
                    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Review Paper</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="{{ route('papers.review.store', $paper->id) }}" method="post"
                                    enctype="multipart/form-data" id="reviewForm">
                                    @method('put')
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Catatan</label>
                                            @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER)
                                                @foreach ($comments as $comment)
                                                    <div class="mb-3">
                                                        <label>{{ $comment }}</label>
                                                        <input type="text" name="comments[]" class="form-control"
                                                            required>
                                                    </div>
                                                @endforeach
                                            @else
                                                <input id="note" type="hidden" name="note" required>
                                                <trix-editor input="note"></trix-editor>
                                                @error('note')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            @endif
                                        </div>
                                        @if (Auth::user()->type == \App\Models\User::TYPE_EDITOR)
                                            <div class="mb-3">
                                                <label>Hasil Check Turnitin (Dalam %)</label>
                                                <input type="number" class="form-control" name="result" required>
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <label>File (Opsional)</label>
                                            <input type="file" class="form-control @error('file') is-invalid @enderror"
                                                name="file" accept=".docx,.pdf">
                                            @error('file')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER)
                                            <div class="mb-3">
                                                <label>Status</label>
                                                <select name="status" class="form-control" required>
                                                    <option value="">--pilih--</option>
                                                    <option value="{{ \App\Models\Abstrak::REVISI_MINOR }}">REVISI MINOR
                                                    </option>
                                                    <option value="{{ \App\Models\Abstrak::REVISI_MAYOR }}">REVISI MAYOR
                                                    </option>
                                                    <option value="{{ \App\Models\Abstrak::REJECTED }}">REJECTED</option>
                                                    <option value="{{ \App\Models\Abstrak::ACCEPTED }}">ACCEPTED</option>
                                                </select>
                                            </div>
                                        @elseif (Auth::user()->type == \App\Models\User::TYPE_EDITOR)
                                            <div class="mb-3">
                                                <label>Status</label>
                                                <select name="status" class="form-control" required>
                                                    <option value="">--pilih--</option>
                                                    <option value="{{ \App\Models\Abstrak::REVISI_MINOR }}">TIDAK LULUS
                                                        CHECK TURNITIN</option>
                                                    <option value="{{ \App\Models\Abstrak::REVIEW }}">LULUS CHECK TURNITIN
                                                    </option>
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit" id="submitButton">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header">
            Revisi <span class="badge badge-danger">{{ count($revisis) }}</span>
        </div>
        <div class="card-body">
            @foreach ($revisis as $revisi)
                <div
                    class="border shadow rounded p-2 mb-2 @if ($revisi->user->type == \App\Models\User::TYPE_EDITOR) border-warning @else border-secondary @endif">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <small
                                class="text-muted">{{ \App\Helpers\AppHelper::parse_date($revisi->created_at) }}</small>
                        </div>
                        <div class="flex-shrink-0">
                            <small
                                class="text-muted">{{ $revisi->user->type == \App\Models\User::TYPE_EDITOR ? 'Checked Turnitin by' : 'Reviewed by' }}
                                <b>{{ $revisi->user->name }}</b></small>
                        </div>
                    </div>
                    {!! nl2br($revisi->note) !!}
                    @if ($revisi->file)
                        <small>File Revisi: <a href="{{ asset($revisi->file) }}" target="_blank"> <i
                                    class="fas fa-download"></i>
                                {{ \App\Helpers\AppHelper::file_short_name($revisi->file) }}</a></small>
                    @endif
                    <br>
                    <small>File Paper: <a href="{{ asset($revisi->file_paper) }}" target="_blank"> <i
                                class="fas fa-download"></i>
                            {{ \App\Helpers\AppHelper::file_short_name($revisi->file_paper) }}</a></small>
                </div>
            @endforeach
            <div class="mt-4">
                {{ $revisis->links() }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });

        document.getElementById('reviewForm').addEventListener('submit', function() {
            var submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Processing...';
        });
    </script>
@endsection
