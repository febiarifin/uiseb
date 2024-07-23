@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">{{ $subtitle }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul Paper</th>
                            <th>Lampiran</th>
                            <th>Tanggal Submit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Judul Paper</th>
                            <th>Lampiran</th>
                            <th>Tanggal Accepted</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($papers as $paper)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $paper->abstrak->title }}</td>
                                <td>
                                    <a href="{{ asset($paper->file) }}" download=""><i class="fas fa-download"></i>
                                        Download</a>
                                </td>
                                <td>{{ \App\Helpers\AppHelper::parse_date_short($paper->acc_at) }}</td>
                                @if (!$paper->is_published)
                                    <td>
                                        <a href="{{ route('paper.published.acc', $paper->id) }}" class="btn btn-primary"
                                            onclick="return confirm('Yakin ingin Acc Publikasi?')"><i
                                                class="fas fa-check-circle"></i> Accepted Publikasi</a>
                                    </td>
                                @else
                                    <td><span class="badge badge-light"> <i class="fas fa-check-circle"></i> Sudah acc publikasi</span></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
