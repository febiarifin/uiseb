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
        <a href="{{ route('register.index') }}" class="primary-btn top-btn"
          ><i class="fa fa-ticket"></i> Register</a
        >
      </div>
      <div id="mobile-menu-wrap"></div>
    </div>
  </header>
  <!-- Header End -->

  <!-- Login Form Section Begin -->
  <section class="contact-from-section spad mt-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title">
            <h2>Login</h2>
            <p>Fill out the form below to continue login.</p>
          </div>
        </div>
      </div>
      @if (session('success'))
      <div class="alert alert-success">
        {!! nl2br(session('success')) !!}
      </div>
      @endif
      <form
        action="{{ route('login.store') }}"
        class="comment-form contact-form" method="POST">
        @csrf
        <div class="row p-3">
          <div class="col-md-12">
            <label>Email</label>
            <input
              type="email"
              placeholder="Input your email"
              name="email"
              required
            />
          </div>
          <div class="col-md-12">
            <label>Password</label>
            <input
              type="password"
              placeholder="Input your password"
              name="password"
              id="password"
              required
            />
          </div>
          <div class="col-12 text-center mt-5">
            <button type="submit" class="site-btn mb-2" id="registerButton">
              LOGIN
            </button>
            <p>
              Don't have account?
              <a href="{{ route('register.index') }}" class="text-primary">Register</a>
            </p>
          </div>
        </div>
      </form>
    </div>
  </section>
  <!-- Login Form Section End -->

@endsection
