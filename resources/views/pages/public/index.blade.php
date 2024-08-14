@extends('layouts.landing-page')

@section('content')
    @include('partials.header')

    <!-- About Section-->
    <section class="hero-section set-bg mt-5"
        data-setbg="{{ asset($page->image_1 ? $page->image_1 : 'manup-master/img/hero.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="hero-text">
                        <span>UPCOMING NEW EVENT {{ $page->name }}</span>
                        <h2>{{ $page->theme }}</h2>
                        <h4 class="text-white">
                            {!! nl2br($page->about_1) !!}
                        </h4>
                        {{-- <div class="mainmenu">
                        </div> --}}
                        @if ($setting->flayer)
                            <a href="{{ asset($setting->flayer) }}" class="primary-btn mt-4">DOWNLOAD FLAYER</a>
                        @else
                            <a href="#about-section" class="primary-btn mt-4">MORE INFORMATION</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-5">
                    <img src="{{ asset($page->image_2 ? $page->image_2 : 'manup-master/img/hero-right.png') }}"
                        alt="" />
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Counter Section Begin -->
    <section class="counter-section bg-gradient" id="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="counter-text">
                        <span>Conference Date</span>
                        <h3>Count Every Second <br />Until the Event</h3>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="cd-timer" id="countdown">
                        <div class="cd-item">
                            <span>00</span>
                            <p>Days</p>
                        </div>
                        <div class="cd-item">
                            <span>00</span>
                            <p>Hours</p>
                        </div>
                        <div class="cd-item">
                            <span>00</span>
                            <p>Minutes</p>
                        </div>
                        <div class="cd-item">
                            <span>00</span>
                            <p>Seconds</p>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a target="_blank" rel="noopener" target="_blank"
                            href="https://calendar.google.com/calendar/render?action=TEMPLATE&dates={{ $deadline_date }}T180000Z%2F{{ $deadline_date }}T200000Z&details=UISEB"
                            class="cta btn-yellow"
                            style="background-color: #F4D66C; font-size: 18px; font-family: Helvetica, Arial, sans-serif; font-weight:bold; text-decoration: none; padding: 14px 20px; color: #1D2025; border-radius: 5px; display:inline-block; mso-padding-alt:0; box-shadow:0 3px 6px rgba(0,0,0,.2);"><span
                                style="mso-text-raise:15pt;">Add to your Google Calendar {{ $deadline_date }}</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter Section End -->

    <!-- Home About Section Begin -->
    <section class="home-about-section spad bg-batik">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ha-pic">
                        <img src="{{ asset($page->image_3 ? $page->image_3 : 'manup-master/img/blog/blog-details/blog-more-2.jpg') }}"
                            alt="" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ha-text">
                        {{-- <h2>WELCOME {{ $page->theme }}</h2> --}}
                        <h2>WELCOME {{ $page->theme }}</h2>
                        <p class="text-justify">
                            {!! nl2br($page->about_2) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Home About Section End -->

    <!-- Speaker Section Begin -->
    <section class="team-member-section bg-wayang" id="conference-section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Who’s speaking</h2>
                        <p>
                            These are our communicators, you can see each person information
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 p-3">
                <h3 class="mt-5 text-center">INVITED SPEAKER</h3>
                <div class="row mt-5 mb-5 justify-content-center">
                    @foreach ($page->speakers()->where('is_keynote', \App\Models\Speaker::IS_INVITED)->get() as $invited)
                        <div class="col-md-4 text-center position-relative" style="overflow: hidden;">
                            @if ($speaker->logo)
                                <div class="background-image-2"
                                    style="background-image: url('{{ asset($speaker->logo) }}');"></div>
                            @endif

                            @if ($speaker->image)
                                <img src="{{ asset($speaker->image) }}" class="rounded" alt="Speaker Image"
                                    height="150" />
                            @endif

                            <p>
                                <b>{{ $speaker->name }}</b> <br />
                                {{ $speaker->institution }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6 text-center p-3">
                <h3 class="mt-5">KEYNOTE SPEAKER</h3>
                <div class="row mt-5 mb-5 justify-content-center">
                    @foreach ($page->speakers()->where('is_keynote', \App\Models\Speaker::IS_KEYNOTE)->get() as $keynote)
                        <div class="col-md-4 p-2 text-center position-relative box-speaker" style="overflow: hidden;">
                            @if ($keynote->logo)
                                <div class="background-image-2"
                                    style="background-image: url('{{ asset($keynote->logo) }}');"></div>
                            @endif

                            @if ($keynote->image)
                                <img src="{{ asset($keynote->image) }}" class="rounded" alt="Speaker Image"
                                    height="150" />
                            @endif

                            <p>
                                <b>{{ $keynote->name }}</b> <br />
                                {{ $keynote->institution }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!--Speaker Section End -->

    <!--Scope and Timeline -->
    <section class="scope-timeline-section spad bg-batik">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6">
                    <div class="ha-text">
                        <h2>CONFERENCE SCOPE</h2>
                        <div class="container">
                            {!! nl2br($page->scope) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ha-text">
                        <h2>IMPORTANT DATES</h2>
                        <ul class="timeline">
                            @foreach ($page->timelines as $timeline)
                                <li>
                                    <span class="text-primary">{{ $timeline->name }}</span>
                                    <span class="float-right text-primary">
                                        {{ \App\Helpers\AppHelper::parse_date_timeline($timeline->date) }}
                                        @if ($timeline->date_end)
                                            - {{ \App\Helpers\AppHelper::parse_date_timeline($timeline->date_end) }}
                                        @endif
                                    </span>
                                    <p class="text-justify">{{ $timeline->description }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Scope and Timeline End -->

    <!-- Pricing Section Begin -->
    <section class="pricing-section set-bg spad"
        data-setbg="{{ asset($page->image_1 ? $page->image_1 : 'manup-master/img/pricing-bg.jpg') }}"
        id="registration-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>REGISTRATION FEE</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($categories as $category)
                    <div class="col-lg-3 col-md-6">
                        <div class="price-item">
                            <h4>{{ $category->name }}
                                @if ($category->is_paper)
                                    + PAPER
                                @endif
                            </h4>
                            <div class="pi-price">
                                <h5 class="text-white">{{ \App\Helpers\AppHelper::currency($category) }}</h5>
                            </div>
                            <p class="p-2">{{ $category->description }}</p>
                            <a href="{{ route('register.index') }}" class="price-btn">REGISTER <span
                                    class="arrow_right"></span></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Pricing Section End -->

    <!-- Committeess Section Begin -->
    <section class="schedule-section spad bg-wayang">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>COMMITTEES</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="schedule-tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item col-6">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                    <h5><span class="icon_plus_alt2"></span></h5>
                                    <p>TECHNICAL COMMITTEE</p>
                                </a>
                            </li>
                            <li class="nav-item col-6">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">
                                    <h5><span class="icon_plus_alt2"></span></h5>
                                    <p>CONFERENCE EDITOR</p>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="st-content">
                                    <div class="container">
                                        <p><b>Technical Committee:</b></p>
                                        @foreach ($committees as $committee)
                                            <p>{{ $committee->name }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="st-content">
                                    <div class="container">
                                        <table class="table">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Affiliations</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($editors as $editor)
                                                    <tr>
                                                        <th scope="row">{{ $no++ }}</th>
                                                        <td>
                                                            <a href="{{ $editor->scopus }}" class="text-primary"
                                                                target="_blank">{{ $editor->name }}</a>
                                                        </td>
                                                        <td>{{ $editor->institution }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Committeess Section End -->

    <!-- Submission Section Begin -->
    <section class="latest-blog spad bg-batik" id="submission-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>SUBMISSION</h2>
                    </div>
                </div>
            </div>
            <div class="p-3">
                <h4>Author Guidelines</h4>
                <ol class="m-4">
                    {!! nl2br($page->submission) !!}
                </ol>
                <div class="mt-5 mb-5 text-center">
                    <a href="{{ route('register.index') }}" class="primary-btn">REGISTRATION</a>
                </div>
            </div>
            <div class="mt-5 col-12 text-center">
                @if ($setting->template_abstract)
                    <a href="{{ asset($setting->template_abstract) }}" class="primary-btn mb-3">Template Abstrak</a>
                @endif
                @if ($setting->template_full_paper)
                    <a href="{{ asset($setting->template_full_paper) }}" class="primary-btn mb-3">Template Full Paper</a>
                @endif
                @if ($setting->confirmation_letter)
                    <a href="{{ asset($setting->confirmation_letter) }}" class="primary-btn mb-3">Confirmation Letter</a>
                @endif
                @if ($setting->copyright_letter)
                    <a href="{{ asset($setting->copyright_letter) }}" class="primary-btn mb-3">Copyright Letter</a>
                @endif
                @if ($setting->self_declare_letter)
                    <a href="{{ asset($setting->self_declare_letter) }}" class="primary-btn mb-3">Self Declare Letter</a>
                @endif
                @if ($setting->template_video)
                    <a href="{{ asset($setting->template_video) }}" class="primary-btn" target="_blank">Template
                        Video</a>
                @endif
            </div>
            <div class="row mt-5" id="publication-section">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>ARTICLE PUBLICATION:</h2>
                        <p style="text-align: left !important; color:black;" class="mb-3">
                            All articles will be published in EDP Sciences (WoS indexed), and selected papers will be
                            published in Sinta and Scopus journals.
                        </p>
                        <ol style="text-align: left;">
                            <li>Paper Asia (Scopus Q3)</li>
                            <li>Management and Accounting Review (MAR) (Scopus Q4)</li>
                            <li>Proceeding will be published in EDP Science (WoS)</li>
                            <li>Jurnal Fokus Bisnis (FokBis) (Sirnta 3)</li>
                            <li>Jurnal Akuntansi FEB UNSIL (Sinta 3)</li>
                            <li>Jurnal Perpajakan, Manajemen, dan Akuntansi (Permana) (Sinta 4)</li>
                            <li>Syariati: Jurnal Studi Al-Qur'an dan Hukum (Sinta 4)</li>
                            <li>Al-Arbah: Journal of lslamic Finance and Banking (Sinta 4)</li>
                            <li>Among Makarti: Jurnal Ekonomi dan Bisnis (Sinta 4)</li>
                            <li>Journal of Economic, Management, Accounting, and Technology (Jematech) (Sinta 4)</li>
                            <li>Jurnal Cakrawala Indonesia (Sinta 4)</li>
                            <li>Jurnal lImiah Akuntansi dan Keuangan IAK (Sinta 5)</li>
                            <li>Jurnal Akuntansi dan Mangjemen (Akmen) (Sinta 5)</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h4>Check our previous Conference Proceedings</h4>
                </div>
                <div class="col-12 text-center">
                    @foreach ($page->articles as $article)
                        <a href="{{ $article->link }}" class="primary-btn col-4"
                            target="_blank">{{ $article->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Submission Section End -->

    <!-- Contact Section Begin -->
    <section class="contact-section spad bg-wayang">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h2>CONTACT US</h2>
                    </div>
                    <div class="cs-text">
                        <div class="ct-address">
                            <span>Address:</span>
                            <p>Faculty of Economic and Busines UNSIQ <br /> Jl. KH. Hasyim Asy'ari Km. 03, Kaliber,
                                Kec. Mojotengah, Kab. Wonosobo,
                                Jawa Tengah - 56351</p>
                        </div>
                        <ul>
                            <li>
                                <span>Telephone:</span>
                                (0286) 3396204
                            </li>
                            <li>
                                <span>Email:</span>
                                uiseb@feb-unsiq.ac.id
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-title">
                        <h2>CONTACT PERSON</h2>
                    </div>
                    <div class="cs-text">
                        @foreach ($page->contacts as $contact)
                            <a href="https://api.whatsapp.com/send?phone={{ $contact->phone_number }}"
                                class="text-primary" target="_blank"> {{ $contact->phone_number }}
                                ({{ $contact->name }})
                            </a>
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->
    <div class="text-center p-2" style="background-color: #f3f3f3;">
        <img src="{{ asset('assets/images/Web_of_Science-2.png') }}" height="80">
        <img src="{{ asset('assets/images/Scopus_logo.png') }}" height="80">
        <img src="{{ asset('assets/images/sinta_logo.png') }}" height="80">
    </div>
    @if (count($page->sponsors) != 0)
        <div class="text-center p-2" style="background-color: #f3f3f3;">
            @foreach ($page->sponsors as $sponsor)
                <img src="{{ asset($sponsor->image) }}" height="80">
            @endforeach
        </div>
    @endif
@endsection
@section('script')
    <script>
        var timerdate = {{ $month }} + '/' + {{ $day }} + '/' + {{ $year }};
        $("#countdown").countdown(timerdate, function(event) {
            $(this).html(event.strftime("<div class='cd-item'><span>%D</span> <p>Days</p> </div>" +
                "<div class='cd-item'><span>%H</span> <p>Hrs</p> </div>" +
                "<div class='cd-item'><span>%M</span> <p>Mins</p> </div>" +
                "<div class='cd-item'><span>%S</span> <p>Secs</p> </div>"));
        });
    </script>
@endsection
