@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-grow-1">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
            <div class="flex-shrink-0">
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
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" class="form-control" value="{{ $abstrak->title }}" name="title" disabled>
            </div>
            <div class="mb-3">
                <form action="{{ route('abstrak.update.author', $abstrak->id) }}" method="post">
                    @method('put')
                    @csrf
                    <label>Author</label>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Depan</th>
                                <th>Nama Tengah</th>
                                <th>Nama Belakang</th>
                                <th>Email</th>
                                <th>Afiliasi</th>
                                <th>Degree</th>
                                <th>Address</th>
                                <th>Research Interest</th>
                                <th>Is Coresponding</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (Auth::user()->type == \App\Models\User::TYPE_ADMIN || Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN)
                                @foreach ($abstrak->penulis as $author)
                                    <tr>
                                        <td><input type="text" class="form-control" value="{{ $author->first_name }}"
                                                name="first_names[]" required></td>
                                        <td><input type="text" class="form-control" value="{{ $author->middle_name }}"
                                                name="middle_names[]"></td>
                                        <td><input type="text" class="form-control" value="{{ $author->last_name }}"
                                                name="last_names[]"></td>
                                        <td><input type="text" class="form-control" value="{{ $author->email }}"
                                                name="emails[]" required></td>
                                        <td><input type="text" class="form-control" value="{{ $author->affiliate }}"
                                                name="affiliates[]" required></td>
                                        <td>
                                            <select name="degrees[]" class="form-control" required>
                                                <option value="">--Choose--</option>
                                                <option value="Associate degree"
                                                    {{ $author->degree == 'Associate degree' ? 'selected' : null }}>
                                                    Associate
                                                    degree
                                                </option>
                                                <option value="Bachelor’s degree"
                                                    {{ $author->degree == 'Bachelor’s degree' ? 'selected' : null }}>
                                                    Bachelor’s
                                                    degree</option>
                                                <option value="Master’s degree"
                                                    {{ $author->degree == 'Master’s degree' ? 'selected' : null }}>Master’s
                                                    degree
                                                </option>
                                                <option value="Doctoral degree"
                                                    {{ $author->degree == 'Doctoral degree' ? 'selected' : null }}>Doctoral
                                                    degree
                                                </option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" value="{{ $author->address }}"
                                                name="address[]" required></td>
                                        <td><input type="text" class="form-control"
                                                value="{{ $author->research_interest }}" name="research_interests[]"
                                                required></td>
                                        <td>
                                            <select name="corespondings[]" class="form-control" required>
                                                <option value="1" {{ $author->coresponding ? 'selected' : null }}>Yes
                                                </option>
                                                <option value="0" {{ !$author->coresponding ? 'selected' : null }}>No
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach ($abstrak->penulis as $author)
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
                            @endif
                        </tbody>
                    </table>
                    @if (Auth::user()->type == \App\Models\User::TYPE_ADMIN || Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN)
                        <button class="btn btn-secondary btn-sm" id="addButton"><i class="fas fa-plus-circle"></i> Add
                            Author</button> <button type="submit" class="btn btn-primary btn-sm"><i
                                class="fas fa-check-circle"></i>
                            Simpan</button>
                    @endif
                </form>
            </div>
            <div class="mb-3">
                @if (Auth::user()->type != \App\Models\User::TYPE_PESERTA)
                    <label>Reviewer</label>
                    <br>
                    @foreach ($abstrak->users as $user)
                        <span class="p-1 border rounded mr-2">@ {{ $user->name }}
                            @if (Auth::user()->type == \App\Models\User::TYPE_EDITOR)
                                <a href="{{ route('abstraks.reviewer.delete', $user->pivot->id) }}"
                                    class="btn btn-light btn-sm" onclick="return confirm('Yakin ingin hapus reviewer?')"><i
                                        class="fas fa-trash"></i></a>
                            @endif
                        </span>
                    @endforeach
                @endif
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
                                <form action="{{ route('abstraks.reviewer.store', $abstrak->id) }}" method="post">
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
            <div class="mb-3">
                <label>Abstrak</label>
                <div class="p-2 rounded border">
                    {!! nl2br($abstrak->abstract) !!}
                </div>
            </div>
            <div class="mb-3">
                <label>Keyword</label>
                <br>
                @php
                    $keywords = explode(',', $abstrak->keyword);
                @endphp
                @foreach ($keywords as $keyword)
                    <span class="badge badge-info mr-1">{{ $keyword }}</span>
                @endforeach
            </div>
            @if ($abstrak->acc_at)
                <div class="mb-3">
                    <label><i class="fas fa-calendar"></i> Accepted At</label>
                    <b class="text-success">{{ \App\Helpers\AppHelper::parse_date_short($abstrak->acc_at) }}</b>
                </div>
            @endif
            <div class="mb-3">
                <label>Lampiran</label>
                @if ($abstrak->file)
                    <iframe src="https://docs.google.com/gview?url={{ asset($abstrak->file) }}&embedded=true"
                        style="width:100%; height:500px;"></iframe>
                    <a href="{{ asset($abstrak->file) }}" target="_blank" download><i class="fas fa-download"></i>
                        Download Lampiran</a>
                @endif
            </div>
            @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER ||
                    Auth::user()->type == \App\Models\User::TYPE_EDITOR ||
                    Auth::user()->type == \App\Models\User::TYPE_ADMIN ||
                    Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN)
                <div class="mt-4">
                    @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER)
                        @if ($abstrak->status == \App\Models\Abstrak::REVIEW ||
                        Auth::user()->type == \App\Models\User::TYPE_ADMIN ||
                        Auth::user()->type == \App\Models\User::TYPE_SUPER_ADMIN)
                            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal"
                                data-target="#reviewModal">
                                <i class="fas fa-edit"></i> Review Abstrak
                            </a>
                        @endif
                    @else
                        <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#reviewModal">
                            <i class="fas fa-edit"></i>Hasil Check Turnitin
                        </a>
                    @endif
                    <!-- Revisi Abstrak Modal-->
                    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Review Abstrak</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="{{ route('abstraks.review.store', $abstrak->id) }}" method="post"
                                    enctype="multipart/form-data" id="reviewForm">
                                    @method('put')
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Catatan</label>
                                            <input id="note" type="hidden" name="note" required>
                                            <trix-editor input="note"></trix-editor>
                                            @error('note')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
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
                                        {{-- @if (Auth::user()->type == \App\Models\User::TYPE_REVIEWER || Auth::user()->type == \App\Models\User::TYPE_EDITOR) --}}
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
                                        {{-- @endif --}}
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
                    <small>File Abstrak: <a href="{{ asset($revisi->file_abstrak) }}" target="_blank"> <i
                                class="fas fa-download"></i>
                            {{ \App\Helpers\AppHelper::file_short_name($revisi->file_abstrak) }}</a></small>
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

        document.getElementById('addButton').addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah reload halaman saat tombol ditekan

            // Cari tabel dan baris terakhir
            const tableBody = document.querySelector('table tbody'); // Pastikan ini mengacu ke tbody yang sesuai
            const lastRow = tableBody.querySelector('tr:last-child'); // Ambil baris terakhir

            // Clone baris terakhir
            const newRow = lastRow.cloneNode(true);

            // Hapus nilai dari input pada baris yang baru
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

            // Tambahkan baris baru ke dalam tabel
            tableBody.appendChild(newRow);
        });
    </script>
@endsection
