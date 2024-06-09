@extends('layouts.dashboard')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <div class="flex-shrink-0">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('categories.update', $category->id) }}" method="post">
            @method('put')
            @csrf
            <div class="mb-3">
                <label>Nama Kategori</label>
                <input type="text" class="form-control" name="name" value="{{ $category->name }}" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi Kategori</label>
                <textarea name="description" class="form-control" required>{{ $category->description }}</textarea>
            </div>
            <div class="mb-3">
                <label>Fee Kategori</label>
                <input type="number" class="form-control" name="amount" value="{{ $category->amount }}" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_paper" @if ($category->is_paper)
                checked
                @endif>
                <label class="form-check-label" for="flexCheckDefault">
                  Dengan Paper
                </label>
            </div>
            <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-check"></i> SIMPAN</button>
        </form>
    </div>
</div>

@endsection
