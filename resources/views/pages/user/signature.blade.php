@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('upload.signature.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Upload Signature (Format: PNG, Max Size: 500 KB) <br>
                    <small>Upload the signature of one of the authors</small></label>
                    <input type="file" class="form-control" name="signature" accept=".png" required>
                </div>
                @if ($user->signature)
                    <div class="mb-3">
                        <img src="{{ asset($user->signature) }}" height="100">
                    </div>
                @endif
                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-check"></i> SIMPAN</button>
            </form>
        </div>
    </div>
@endsection
