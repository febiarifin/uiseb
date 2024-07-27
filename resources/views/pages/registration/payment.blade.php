@extends('layouts.dashboard')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <div class="flex-shrink-0">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('upload.payment', $registration->id) }}" method="post" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="alert alert-primary mb-3">
                {!! nl2br($setting->information) !!}
            </div>
            <div class="mb-3">
                <label>Bukti Pembayaran (Format: jpg, jpeg, png. Max: 500Kb)</label>
                <input type="file" class="form-control @error('payment_image') is-invalid @enderror" name="payment_image" accept=".jpg,.jpeg,.png" required>
                @error('payment_image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-check"></i> SIMPAN</button>
        </form>
    </div>
</div>

@endsection
