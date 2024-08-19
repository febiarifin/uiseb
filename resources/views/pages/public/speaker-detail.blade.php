@extends('layouts.landing-page')

@section('content')
    @include('partials.header')
    <br><br><br><br><br><br>
    <div class="p-10 bg-surface-secondary">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Component -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <a href="#" class="avatar avatar-xl">
                                <img alt="{{ $speaker->name }}"
                                    src="{{ asset($speaker->image) }}" class="rounded-circle" height="200">
                            </a>
                        </div>
                        <div class="text-center my-6">
                            <!-- Title -->
                            <span class="d-block h4 mb-0 text-primary mt-3">{{ $speaker->name }}</span>
                            <!-- Subtitle -->
                            <span class="d-block text-sm text-blank">{{ $speaker->institution }}</span>
                            <hr>
                            <p class="text-justify text-muted">
                                {{ $speaker->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
@endsection
