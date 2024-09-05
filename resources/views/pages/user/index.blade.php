@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">{{ $subtitle }}</h6>
            <div class="flex-shrink-0">
                <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#createModal">
                    <i class="fas fa-plus"></i> Buat User Baru
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>
                                    <a href="{{ $user->scopus ? $user->scopus : '#' }}"
                                        @if ($user->scopus) target="_blank" @endif>{{ $user->name }}</a>
                                </td>
                                <td>{{ $user->email }}
                                    @if ($user->type == \App\Models\User::TYPE_PESERTA)
                                        @if ($user->is_email_verified)
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i>
                                                verified</span>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ \App\Helpers\AppHelper::parse_date_short($user->created_at) }}</td>
                                <td>
                                    <span class="badge badge-secondary">
                                        @if ($user->type == \App\Models\User::TYPE_EDITOR)
                                            EDITOR
                                        @elseif ($user->type == \App\Models\User::TYPE_REVIEWER)
                                            REVIEWER
                                        @elseif ($user->type == \App\Models\User::TYPE_PESERTA)
                                            PESERTA
                                        @elseif ($user->type == \App\Models\User::TYPE_COMMITTEE)
                                            COMMITTEE
                                        @endif
                                    </span>
                                </td>
                                <td class="d-flex">
                                    @if (count($user->registrations) != 0)
                                        <a href="#" class="btn btn-default btn-sm"><i class="fas fa-info-circle"></i>
                                            Sudah ada pendaftaran</a>
                                    @else
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm"><i
                                                class="fas fa-edit"></i></a>
                                        &nbsp;
                                        <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin dihapus?')"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                    &nbsp;
                                    <a href="{{ route('user.reset', $user->id) }}" class="btn btn-warning btn-sm"  onclick="return confirm('Yakin ingin reset password user {{ $user->name }}?')"><i class="fas fa-lock"></i>
                                        Reset Password</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Modal-->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat User Baru</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('users.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama (Tulis dengan gelar)</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label>Institusi</label>
                            <input type="text" class="form-control" name="institution" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label>Role</label>
                            <select name="type" class="form-control">
                                <option value="">--pilih--</option>
                                <option value="{{ \App\Models\User::TYPE_COMMITTEE }}">COMMITTEE</option>
                                <option value="{{ \App\Models\User::TYPE_EDITOR }}">EDITOR</option>
                                <option value="{{ \App\Models\User::TYPE_REVIEWER }}">REVIEWER</option>
                                <option value="{{ \App\Models\User::TYPE_PESERTA }}">PESERTA</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Scopus Link</label>
                            <input type="url" class="form-control" name="scopus" required>
                        </div>
                        <div class="mb-3">
                            <label>Jabatan (Jika kosong isikan dengan -)</label>
                            <input type="text" class="form-control" name="position" required>
                        </div>
                        <div class="mb-3">
                            <label>Password Default</label>
                            <input type="text" class="form-control" value="UISEB247" disabled>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
