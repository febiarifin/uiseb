@extends('layouts.dashboard')

@section('content')
    <div class="row">
        @if (Auth::user()->type == \App\Models\User::TYPE_ADMIN)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah User</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($users) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Kategori</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($categories) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Pendaftaran
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($registrations) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-star fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::user()->type == \App\Models\User::TYPE_ADMIN || Auth::user()->type == \App\Models\User::TYPE_REVIEWER)
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Validasi Pendaftaran Terbaru</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($registrations_validation as $registration)
                            <div class="col-12 card shadow mb-2 p-3">
                                <span>
                                    {{ \App\Helpers\AppHelper::parse_date_short($registration->created_at) }}
                                    &nbsp;
                                    PENDAFTARAN <b>{{ $registration->category->name }}</b>
                                </span>
                            </div>
                        @endforeach
                        @if (count($registrations_validation) != 0)
                            <a href="{{ route('registration.validation') }}" class="mt-3">Show all registration <i
                                    class="fas fa-arrow-right"></i></a>
                        @else
                            Tidak ada pendaftaran terbaru
                        @endif
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::user()->type == \App\Models\User::TYPE_ADMIN ||
                Auth::user()->type == \App\Models\User::TYPE_EDITOR ||
                Auth::user()->type == \App\Models\User::TYPE_REVIEWER)
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Review Paper Terbaru</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($registrations_reviews as $registration)
                            <div class="col-12 card shadow mb-2 p-3">
                                <span>
                                    {{ \App\Helpers\AppHelper::parse_date_short($registration->created_at) }}
                                    &nbsp;
                                    PAPER <b>{{ $registration->user->name . ' / ' . $registration->user->email }}</b>
                                </span>
                            </div>
                        @endforeach
                        @if (count($registrations_reviews) != 0)
                            <a href="{{ route('registration.reviews') }}" class="mt-3">Show all paper <i
                                    class="fas fa-arrow-right"></i></a>
                        @else
                            Tidak ada paper terbaru
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
