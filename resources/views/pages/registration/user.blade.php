@extends('layouts.dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary flex-grow-1">{{ $subtitle }}</h6>
            <div class="flex-shrink-0">
                <a href="{{ route('registration.list') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle"></i>
                    New Registration</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Fee</th>
                            <th>Registration At</th>
                            <th>Validated At</th>
                            <th>Acc At</th>
                            <th>Validity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Fee</th>
                            <th>Registration At</th>
                            <th>Validated At</th>
                            <th>Acc At</th>
                            <th>Validity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($registrations as $registration)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $registration->category->name }}
                                    @if ($registration->is_paper)
                                        <span class="badge badge-secondary">+ PAPER</span>
                                    @endif
                                </td>
                                <td>{{ \App\Helpers\AppHelper::currency($registration->category->amount) }}</td>
                                <td>{{ \App\Helpers\AppHelper::parse_date($registration->created_at) }}</td>
                                <td>{{ $registration->validated_at ? \App\Helpers\AppHelper::parse_date($registration->validated_at) : null }}
                                </td>
                                <td>{{ $registration->acc_at ? \App\Helpers\AppHelper::parse_date($registration->acc_at) : null }}
                                </td>
                                <td>
                                    @if ($registration->is_valid == \App\Models\Registration::IS_VALID)
                                        <span class="badge badge-success">VALID</span>
                                    @elseif ($registration->is_valid == \App\Models\Registration::NOT_VALID)
                                        <span class="badge badge-warning">NOT VALID</span>
                                    @elseif ($registration->payment_image)
                                        <span class="badge badge-secondary">REVIEW</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($registration->category->is_paper)
                                        @if ($registration->status == \App\Models\Registration::REVIEW)
                                            <span class="badge badge-secondary">REVIEW</span>
                                        @elseif ($registration->status == \App\Models\Registration::REVISI)
                                            <span class="badge badge-warning">REVISI</span>
                                        @elseif ($registration->status == \App\Models\Registration::ACC)
                                            <span class="badge badge-success">ACC</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="d-flex">
                                    @if ($registration->category->is_paper)
                                        @if ($registration->status == \App\Models\Registration::ACC)
                                            @if (!$registration->payment_image)
                                                <a href="{{ route('upload.payment', $registration->id) }}"
                                                    class="btn btn-primary btn-sm mt-2"><i
                                                        class="fas fa-upload"></i> Upload
                                                    Pembayaran</a>
                                            @endif
                                        @else
                                            @if (!$registration->paper || $registration->status == \App\Models\Registration::REVISI)
                                                <a href="{{ route('upload.paper', $registration->id) }}"
                                                    class="btn btn-primary btn-sm mt-2"><i
                                                        class="fas fa-upload"></i> Upload
                                                    Paper</a>
                                            @endif
                                        @endif
                                    @else
                                        @if (!$registration->payment_image || $registration->is_valid == \App\Models\Registration::NOT_VALID)
                                            <a href="{{ route('upload.payment', $registration->id) }}"
                                                class="btn btn-primary btn-sm mt-2"><i class="fas fa-upload"></i>
                                                Upload Pembayaran</a>
                                        @endif
                                    @endif
                                    &nbsp;
                                    <a href="{{ route('registration.detail', $registration->id) }}"
                                        class="btn btn-info btn-sm mt-2"><i class="fas fa-info-circle"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
