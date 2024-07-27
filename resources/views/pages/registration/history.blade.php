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
                            <th>Nama Peserta</th>
                            <th>Email Peserta</th>
                            <th>Kategori Pendaftaran</th>
                            <th>Harga</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Peserta</th>
                            <th>Email Peserta</th>
                            <th>Kategori Pendaftaran</th>
                            <th>Harga</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($registrations as $registration)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $registration->user->name }}</td>
                                <td>{{ $registration->user->email }}</td>
                                <td>{{ $registration->category->name }}
                                    @if ($registration->category->is_paper)
                                        <span class="badge badge-secondary">+ PAPER</span>
                                    @endif
                                </td>
                                <td>{{ \App\Helpers\AppHelper::currency($registration->category) }}</td>
                                <td>{{ \App\Helpers\AppHelper::parse_date($registration->created_at) }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('registration.detail', $registration->id) }}"
                                        class="btn btn-primary btn-sm"><i class="fas fa-info-circle"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
