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
        <a href="{{ route('login.index') }}" class="primary-btn top-btn"
          ><i class="fa fa-ticket"></i> Login</a
        >
      </div>
      <div id="mobile-menu-wrap"></div>
    </div>
  </header>
  <!-- Header End -->

  <!-- Contact Form Section Begin -->
  <section class="contact-from-section spad mt-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title">
            <h2>Registration</h2>
            <p>Fill out the form below to continue registration.</p>
          </div>
        </div>
      </div>
      <form
        action="{{ route('register.store') }}"
        id="registerForm"
        class="comment-form contact-form" method="POST">
        @csrf
        <div class="row p-3">
          <div class="col-md-6">
            <label>Full Name (For Certificate)</label>
            <input
              type="text"
              placeholder="Input your full name"
              name="name"
              value="{{ old('name') }}"
              required
            />
          </div>
          <div class="col-md-6">
            <label>Email</label>
            <input
              type="email"
              placeholder="Input your email"
              name="email"
              value="{{ old('email') }}"
              required
            />
            @error('email')
            <small style="position: relative; top:-20px;"><span class="text-danger">{{ $message }}</span></small>
            @enderror
          </div>
          <div class="col-md-6">
            <label>Phone Number</label>
            <input
              type="text"
              placeholder="Input your phone number"
              name="phone_number"
              value="{{ old('phone_number') }}"
              required
            />
          </div>
          <div class="col-md-6">
            <label>Institution</label>
            <input
              type="text"
              placeholder="Input your Institution"
              required
              name="institution"
              value="{{ old('institution') }}"
            />
          </div>
          <div class="col-md-6">
            <label>Position</label>
            <select name="position" required>
              <option value="">--pilih--</option>
              <option value="Lecturer">Lecturer</option>
              <option value="Researcher">Researcher</option>
              <option value="Teacher">Teacher</option>
              <option value="Student">Student</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Subject Background</label>
            <select name="subject_background" required>
              <option value="">--pilih--</option>
              <option value="Pharmacy">Pharmacy</option>
              <option value="Chemistry">Chemistry</option>
              <option value="Statistics">Statistics</option>
              <option value="Engineering, etc.">Engineering, etc.</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Password</label>
            <input
              type="password"
              placeholder="Input your password"
              name="password"
              id="password"
              required
            />
          </div>
          <div class="col-md-6">
            <label>Confirm Password</label>
            <input
              type="password"
              placeholder="Input your password confirmation"
              name="confirm_password"
              id="confirm_password"
              required
            />
          </div>
          <div class="col-md-12">
            <label>Category</label>
            <select name="category_id" required>
              <option value="">--pilih--</option>
              @foreach ($categories as $category)
              <option value="{{ $category->id }}">
                {{ $category->name }}
                @if ($category->is_paper)
                    <span class="badge badge-secondary"> + PAPER</span>
                @endif
                - {{ \App\Helpers\AppHelper::currency($category->amount) }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="col-12 text-center mt-5">
            <button type="submit" class="site-btn mb-2" id="registerButton">
              REGISTER
            </button>
            <p>
              Already have account?
              <a href="{{ route('login.index') }}" class="text-primary">Login</a>
            </p>
          </div>
        </div>
      </form>
    </div>
  </section>
  <!-- Contact Form Section End -->

@endsection
