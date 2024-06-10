@extends('layouts.dashboard')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <div class="flex-shrink-0">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('upload.paper', $registration->id) }}" method="post" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="alert alert-primary mb-3">
                Upload Paper Instruction <a href="" target="_blank">READING INSTRUCTION</a>
            </div>
            <div class="mb-3">
                <label>Bukti Pembayaran (Format: pdf. Max: 1Mb)</label>
                <input type="file" class="form-control @error('paper') is-invalid @enderror" name="paper" accept=".pdf" required>
                @error('paper')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-check"></i> SIMPAN</button>
        </form>
    </div>
</div>

@endsection
