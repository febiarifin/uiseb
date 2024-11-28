@extends('layouts.landing-page')

@section('content')
    @include('partials.header')

    <br><br><br><br>
    <!-- Speaker Section Begin -->
    <div class="team-boxed">
        <div class="container">
            <div class="intro">
                <h2 class="text-center">Who's Speaking </h2>
                <p class="text-center">These are our communicators, you can see each person information</p>
            </div>
            <div class="row people">
                @foreach ($page->speakers as $speaker)
                    @if ($speaker->is_keynote == \App\Models\Speaker::IS_INVITED)
                        <div class="col-md-6 col-lg-4 item">
                            <div class="box"><img class="rounded-circle" src="{{ asset($speaker->image) }}"
                                    style="max-height: 180px;">
                                <h3 class="name">{{ $speaker->name }}</h3>
                                <p class="title">INVITED SPEAKER</p>
                                <p class="description">{{ $speaker->institution }}</p>
                                <div class="social">
                                    <a href="{{ route('speaker.detail', $speaker->id) }}"
                                        class="btn btn-outline-secondary btn-sm rounded-pill text-dark">Speaker Detail</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @foreach ($page->speakers as $speaker)
                    @if ($speaker->is_keynote == \App\Models\Speaker::IS_KEYNOTE)
                        <div class="col-md-6 col-lg-4 item">
                            <div class="box"><img class="rounded-circle" src="{{ asset($speaker->image) }}"
                                    style="max-height: 180px;">
                                <h3 class="name">{{ $speaker->name }}</h3>
                                <p class="title">KEYNOTE SPEAKER</p>
                                <p class="description">{{ $speaker->institution }}</p>
                                <div class="social">
                                    <a href="{{ route('speaker.detail', $speaker->id) }}"
                                        class="btn btn-outline-secondary btn-sm rounded-pill text-dark">Speaker Detail</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!--Speaker Section End -->

    <!--Scope and Timeline -->
    <section class="scope-timeline-section spad bg-batik">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="ha-text">
                        <h2 class="text-center">CONFERENCE SCOPE</h2>
                        <div class="container">
                            {!! nl2br($page->scope) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="ha-text">
                        <h2 class="text-center">IMPORTANT DATES</h2>
                        {{-- <ul class="timeline">
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
                        </ul> --}}
                        <div class="col-xl-12">
                            <ul class="timeline-list">
                                @foreach ($page->timelines as $timeline)
                                    <!-- Single Experience -->
                                    <li>
                                        <div class="timeline_content">
                                            <span>{{ \App\Helpers\AppHelper::parse_date_timeline($timeline->date) }}
                                                @if ($timeline->date_end)
                                                    -
                                                    {{ \App\Helpers\AppHelper::parse_date_timeline($timeline->date_end) }}
                                                @endif
                                            </span>
                                            <h4>{{ $timeline->name }}</h4>
                                            <p>{{ $timeline->description }}</p>
                                        </div>
                                    </li>
                                    <!-- Single Experience -->
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <iframe src="https://drive.google.com/file/d/1hgUUbFcShbSNKsr0GmKUNAAVcMNgOLIj/preview"
                    style="width: 100% !important;" height="500" frameborder="0" class="mt-4"></iframe>
                {{-- <div class="mt-4">
                    <a href="{{ asset('documents/TENTATIVE SCHEDULE WEB UISEB.docx') }}" class="primary-btn">DOWNLOAD
                        TENTATIVE SCHEDULE</a>
                </div> --}}
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
            @if (count($page->articles) != 0)
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
            @endif
        </div>
    </section>
    <!-- Submission Section End -->

    @include('partials.footer')

@endsection
