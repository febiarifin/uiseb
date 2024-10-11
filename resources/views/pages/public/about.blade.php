@extends('layouts.landing-page')

@section('content')
    @include('partials.header')

    <!-- Home About Section Begin -->
    <section class="home-about-section spad bg-batik mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ha-pic">
                        <img src="{{ asset($page->image_4 ? $page->image_4 : 'manup-master/img/blog/blog-details/blog-more-2.jpg') }}"
                            alt="" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ha-text">
                        {{-- <h2>WELCOME {{ $page->theme }}</h2> --}}
                        <h2>WELCOME {{ $page->theme }}</h2>
                        <p class="text-justify">
                            {!! nl2br($page->about_3) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Home About Section End -->

    @include('partials.footer')
@endsection
