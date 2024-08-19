@extends('layouts.landing-page')

@section('content')
    @include('partials.header')

    <br><br><br><br>
    <!-- Speaker Section Begin -->
    <section class="team-member-section bg-wayang mt-5" id="conference-section"  style="background-color: #f2f2f2">
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Template Word</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 mb-5">
                {!! nl2br($page->template_word) !!}
            </div>
        </div>
    </section>
    <!--Speaker Section End -->

    @include('partials.footer')
@endsection
