@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-shrink-0">
                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="post">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label>Nama (Tulis dengan gelar)</label>
                    <input type="text" class="form-control" value="{{ $user->name }}" name="name" required>
                </div>
                <div class="mb-3">
                    <label>Institusi</label>
                    <input type="text" class="form-control" name="institution" value="{{ $user->institution }}" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="mb-3">
                    <label>Role</label>
                    <select name="type" class="form-control">
                        <option value="">--pilih--</option>
                        <option value="{{ \App\Models\User::TYPE_COMMITTEE }}"
                            {{ $user->type == \App\Models\User::TYPE_COMMITTEE ? 'selected' : null }}>COMMITTEE</option>
                        <option value="{{ \App\Models\User::TYPE_EDITOR }}"
                            {{ $user->type == \App\Models\User::TYPE_EDITOR ? 'selected' : null }}>EDITOR</option>
                        <option value="{{ \App\Models\User::TYPE_REVIEWER }}"
                            {{ $user->type == \App\Models\User::TYPE_REVIEWER ? 'selected' : null }}>REVIEWER</option>
                        <option value="{{ \App\Models\User::TYPE_PESERTA }}"
                            {{ $user->type == \App\Models\User::TYPE_PESERTA ? 'selected' : null }}>PESERTA</option>
                    </select>
                </div>
                @if ($user->type != \App\Models\User::TYPE_PESERTA)
                    <div class="mb-3">
                        <label>Scopus Link</label>
                        <input type="url" class="form-control" name="scopus" value="{{ $user->scopus }}" required>
                    </div>
                @endif
                <div class="mb-3">
                    <label>Jabatan (Jika kosong isikan dengan -)</label>
                    <input type="text" class="form-control" name="position" value="{{ $user->position }}" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-check"></i> SIMPAN</button>
            </form>
        </div>
    </div>
@endsection
