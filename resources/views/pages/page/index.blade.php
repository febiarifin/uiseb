@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">{{ $subtitle }}</h6>
            <div class="flex-shrink-0">
                <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#createModal">
                    <i class="fas fa-plus"></i> Buat Halaman Baru
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
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($pages as $page)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $page->name }}</td>
                                <td>
                                    @if ($page->status == \App\Models\Page::ENABLE)
                                        <span class="badge badge-success">AKTIF</span>
                                    @else
                                        <span class="badge badge-danger">TIDAK AKTIF</span>
                                    @endif
                                </td>
                                <td>{{ \App\Helpers\AppHelper::parse_date_short($page->created_at) }}</td>

                                <td class="d-flex">
                                    @if ($page->status == \App\Models\Page::ENABLE)
                                        <a href="{{ route('pages.change', $page->id) }}" class="btn btn-secondary btn-sm" onclick="return confirm('Yakin ingin dinonaktifkan?')"><i
                                                class="fas fa-power-off"></i></a>
                                    @else
                                        <a href="{{ route('pages.change', $page->id) }}" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin diaktifkan?')"><i
                                                class="fas fa-check-circle"></i></a>
                                    @endif
                                    &nbsp;
                                    <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-info btn-sm"><i
                                            class="fas fa-edit"></i></a>
                                    &nbsp;
                                    <form action="{{ route('pages.destroy', $page->id) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin dihapus?')"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
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
                    <h5 class="modal-title" id="exampleModalLabel">Buat Halaman Baru</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('pages.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Halaman</label>
                            <input type="text" class="form-control" name="name" required>
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
