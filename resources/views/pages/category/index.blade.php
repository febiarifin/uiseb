@extends('layouts.dashboard')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary flex-grow-1">{{ $subtitle }}</h6>
        <div class="flex-shrink-0">
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat Kategori</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Fee</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Fee</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $category->name }}
                                @if ($category->is_paper)
                                    <span class="badge badge-secondary">+ PAPER</span>
                                @endif
                            </td>
                            <td>{{ $category->description }}</td>
                            <td>{{ \App\Helpers\AppHelper::currency($category->amount) }}</td>
                            <td class="d-flex">
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                &nbsp;
                                <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin dihapus?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
