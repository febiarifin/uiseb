@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">

        <a href="{{ route('registration.list') }}" class="btn btn-primary mb-4"><i class="fas fa-plus-circle"></i> New
            Registration</a>

        @foreach ($registrations as $registration)
            <div class="col-12 card shadow mb-2 p-3">
                <span>
                    {{ \App\Helpers\AppHelper::parse_date_short($registration->created_at) }}
                    &nbsp;
                    REGISTRATION <b>{{ $registration->category->name }}</b>
                    @if ($registration->category->is_paper)
                        <span class="badge badge-secondary">+ PAPER</span>
                    @endif
                </span>
                {{-- @if ($registration->category->is_paper)
                    @if ($registration->status == \App\Models\Registration::ACC)
                        @if (!$registration->payment_image)
                            <a href="{{ route('upload.payment', $registration->id) }}" class="btn btn-success btn-sm mt-2 col-md-2"><i class="fas fa-upload"></i> Upload
                                Pembayaran</a>
                        @endif
                    @else
                        @if (!$registration->paper || $registration->status == \App\Models\Registration::REVISI)
                            <a href="{{ route('upload.paper', $registration->id) }}" class="btn btn-success btn-sm mt-2 col-md-2"><i class="fas fa-upload"></i> Upload
                                Paper</a>
                        @endif
                    @endif
                @else
                    @if (!$registration->payment_image || $registration->is_valid == \App\Models\Registration::NOT_VALID)
                        <a href="{{ route('upload.payment', $registration->id) }}" class="btn btn-success btn-sm mt-2 col-md-2"><i class="fas fa-upload"></i> Upload
                            Pembayaran</a>
                    @endif
                @endif --}}
                @if (!$registration->payment_image)
                    <a href="{{ route('upload.payment', $registration->id) }}" class="btn btn-success btn-sm mt-2 col-md-2"><i
                            class="fas fa-upload"></i> Upload
                        Pembayaran</a>
                @else
                    @if ($registration->category->is_paper && $registration->is_valid == \App\Models\Registration::IS_VALID)
                        @if (!$registration->paper || $registration->status == \App\Models\Registration::REVISI)
                            <a href="{{ route('upload.paper', $registration->id) }}"
                                class="btn btn-success btn-sm mt-2 col-md-2"><i class="fas fa-upload"></i> Upload
                                Paper</a>
                        @endif
                    @endif
                @endif
            </div>
        @endforeach

        <div class="mt-3">
            <a href="{{ route('registration.user') }}">Show all registration <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
@endsection
