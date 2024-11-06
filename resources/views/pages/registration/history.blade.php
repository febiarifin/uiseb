@extends('layouts.dashboard')
@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- Buttons extension CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">{{ $subtitle }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="dataTableExport" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Peserta</th>
                            <th>Email Peserta</th>
                            <th>Nomor HP</th>
                            <th>Institusi / Afiliasi</th>
                            <th>Kategori Pendaftaran</th>
                            <th>Harga</th>
                            <th>Tanggal Daftar</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Link Video</th>
                            <th>Reviewer Abstrak</th>
                            <th>Reviewer Paper</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Peserta</th>
                            <th>Email Peserta</th>
                            <th>Nomor HP</th>
                            <th>Institusi / Afiliasi</th>
                            <th>Kategori Pendaftaran</th>
                            <th>Harga</th>
                            <th>Tanggal Daftar</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Link Video</th>
                            <th>Reviewer Abstrak</th>
                            <th>Reviewer Paper</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($registrations as $registration)
                            @php
                                $abstrak = $registration
                                    ->abstraks()
                                    ->where('status', \App\Models\Abstrak::ACCEPTED)
                                    ->first();
                            @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $registration->user->name }}</td>
                                <td>{{ $registration->user->email }}</td>
                                <td>{{ $registration->user->phone_number }}</td>
                                <td>{{ $registration->user->institution }}</td>
                                <td>{{ $registration->category->name }}
                                    @if ($registration->category->is_paper)
                                        <span class="badge badge-secondary">+ PAPER</span>
                                    @endif
                                </td>
                                <td>{{ \App\Helpers\AppHelper::currency($registration->category) }}</td>
                                <td>{{ \App\Helpers\AppHelper::parse_date($registration->created_at) }}</td>
                                <td>
                                    {{ $abstrak ? $abstrak->title : null }}
                                </td>
                                <td>
                                    @if ($abstrak)
                                        @foreach ($abstrak->penulis as $author)
                                            {{ $author->last_name }} {{ $author->first_name }},
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if ($abstrak)
                                        @php
                                            $paper = $abstrak
                                                ->papers()
                                                ->where('status', \App\Models\Paper::ACCEPTED)
                                                ->first();
                                        @endphp
                                        @if ($paper)
                                            @php
                                                $video = $paper
                                                    ->videos()
                                                    ->where('status', \App\Models\Video::ACCEPTED)
                                                    ->first();
                                            @endphp
                                            @if ($video)
                                                <a href="{{ $video->link }}">{{ $video->link }}</a>
                                            @endif
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($abstrak)
                                        @foreach ($abstrak->revisis as $revisi)
                                            {{ $revisi->user->name }},
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if ($abstrak)
                                        @php
                                            $paper = $abstrak
                                                ->papers()
                                                ->where('status', \App\Models\Paper::ACCEPTED)
                                                ->first();
                                        @endphp
                                        @if ($paper)
                                            @foreach ($paper->users as $user)
                                                {{ $user->name }},
                                            @endforeach
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('registration.detail', $registration->id) }}"
                                        class="btn btn-primary btn-sm"><i class="fas fa-info-circle"></i></a>
                                    @if ($abstrak)
                                        <a href="{{ route('abstraks.review', $abstrak->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-info-circle"></i>
                                            Detail Abstrak
                                        </a>
                                        @php
                                            $paper = $abstrak
                                                ->papers()
                                                ->where('status', \App\Models\Paper::ACCEPTED)
                                                ->first();
                                        @endphp
                                        @if ($paper)
                                            <a href="{{ route('papers.show', $paper->id) }}"
                                                class="btn btn-info btn-sm "><i class="fas fa-info-circle"></i> Detail Paper</a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- Buttons extension JS -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#dataTableExport").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection
