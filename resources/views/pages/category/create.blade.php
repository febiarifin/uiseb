@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="flex-shrink-0">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label>Deskripsi Kategori</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Start Fee</label>
                        <input type="text" inputmode="numeric" class="form-control" name="amount" required>
                    </div>
                    <div class="col-md-6">
                        <label>Max Fee</label>
                        <input type="text" inputmode="numeric" class="form-control" name="amount_max">
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_dollar">
                    <label class="form-check-label" for="flexCheckDefault">
                        Mata Uang Dollar
                    </label>
                </div>
                <div class="mb-3">
                    <label>Pilih Halaman</label>
                    <select name="page_id" class="form-control" required>
                        <option value="">--pilih--</option>
                        @foreach ($pages as $page)
                            <option value="{{ $page->id }}">{{ $page->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_paper">
                    <label class="form-check-label" for="flexCheckDefault">
                        Dengan Paper
                    </label>
                </div>
                {{-- <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_active">
                    <label class="form-check-label" for="flexCheckDefault">
                    Aktifkan Kategori
                    </label>
                </div> --}}
                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-check"></i> SIMPAN</button>
            </form>
        </div>
    </div>
@endsection
