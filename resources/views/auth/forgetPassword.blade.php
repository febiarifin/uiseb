@extends('layouts.landing-page')

@section('content')
    <!-- Header Section Begin -->
    <header class="header-section bg-white fixed-top shadow-sm">
        <div class="container">
            <div class="logo">
                <a href="{{ route('public.index') }}">
                    <img src="{{ asset('manup-master') }}/img/logo_UISEB.png" alt="" height="50" />
                </a>
            </div>
            <div class="nav-menu">
                <a href="{{ route('login.index') }}" class="primary-btn top-btn"><i class="fa fa-ticket"></i> Login</a>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->

    <section class="contact-from-section spad mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Reset Password</div>
                        <div class="card-body">

                            @if (Session::has('message'))
                                <div class="alert alert-success" role="alert">
                                    {!! nl2br(Session::get('message')) !!}
                                </div>
                            @endif

                            <form action="{{ route('forget.password.post') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                        Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email_address" class="form-control" name="email"
                                            required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Send Password Reset Link
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
