<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="UISEB Website Official" />
    <meta name="keywords" content="UISEB, International, Seminar, Event, Economics, Busines" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title }}</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600,700,800,900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('manup-master') }}/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ asset('manup-master') }}/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ asset('manup-master') }}/css/elegant-icons.css" type="text/css" />
    <link rel="stylesheet" href="{{ asset('manup-master') }}/css/owl.carousel.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ asset('manup-master') }}/css/magnific-popup.css" type="text/css" />
    <link rel="stylesheet" href="{{ asset('manup-master') }}/css/slicknav.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ asset('manup-master') }}/css/style.css" type="text/css" />
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link rel="shortcut icon" href="{{ asset('manup-master/img/logo_UISEB.png') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/timeline.css') }}">
    
</head>

<body>
    <!-- Page Preloder -->
    <!-- <div id="preloder">
        <div class="loader"></div>
    </div> -->

    @yield('content')

    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-text">
                        <div class="ft-logo">
                            <a href="#" class="footer-logo"><img
                                    src="{{ asset('manup-master/img/logo_UISEB.png') }}" alt=""
                                    height="80" /></a>
                        </div>
                        <ul>
                            <li><a href="https://unsiq.ac.id/" target="_blank">UNSIQ</a></li>
                            <li><a href="https://feb-unsiq.ac.id/" target="_blank">FEB</a></li>
                            <li><a href="https://pmb.unsiq.ac.id/" target="_blank">PMB</a></li>
                        </ul>
                        <div class="copyright-text">
                            <p>
                                Copyright &copy;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                UISEB
                            </p>
                        </div>
                        <div class="ft-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    @include('partials.js-landing-page')
</body>

</html>
