@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-grow-1">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary">
                <i class="fas fa-info-circle"></i> You can see the video template at the following link <a href="{{ asset($setting->template_video) }}" target="_blank"><i class="fab fa-youtube"></i> Video Template</a>
            </div>
            <form action="{{ route('videos.update', $video->id) }}" method="post">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" class="form-control" value="{{ $video->paper->abstrak->title }}" name="title" disabled>
                </div>
                <div class="mb-3">
                    <label>Link Video Youtube</label>
                    <input type="url" class="form-control" name="link" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-check"></i> SIMPAN</button>
            </form>
        </div>
    </div>
@endsection
