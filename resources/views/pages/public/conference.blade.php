@extends('layouts.landing-page')

@section('content')
    @include('partials.header')
    
    <br><br><br>
    <!-- Speaker Section Begin -->
    <section class="team-member-section bg-wayang mt-5" id="conference-section">
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
                            @if ($invited->logo)
                                <div class="background-image-2"
                                    style="background-image: url('{{ asset($invited->logo) }}');"></div>
                            @endif

                            @if ($invited->image)
                                <img src="{{ asset($invited->image) }}" class="rounded" alt="Speaker Image"
                                    height="150" />
                            @endif

                            <p>
                                <b>{{ $invited->name }}</b> <br />
                                {{ $invited->institution }} <br>
                                {{ $invited->description }}
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
                            <p class="text-justify">
                                {{ $keynote->description }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!--Speaker Section End -->

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
                            <a href="https://api.whatsapp.com/send?phone={{ $contact->phone_number }}" class="text-primary"
                                target="_blank"> {{ $contact->phone_number }}
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
