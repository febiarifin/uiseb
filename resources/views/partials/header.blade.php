 <!-- Header Section Begin -->
 <header class="header-section bg-white fixed-top shadow-sm">
    <div class="container">
        <div class="logo">
            <a href="{{ route('public.index') }}">
                <img src="{{ asset('manup-master') }}/img/logo_UISEB.png" alt="" height="40" />
            </a>
        </div>
        <div class="nav-menu">
            <nav class="mainmenu mobile-menu">
                <ul>
                    <li><a href="{{ route('public.index') }}">Home</a></li>
                    <li><a href="{{ route('public.about') }}">About</a></li>
                    <li><a href="{{ route('public.conference') }}">Conference</a></li>
                    <li><a href="#">For Author</a>
                        <ul class="dropdown">
                            <li><a href="{{ route('public.author') }}">Instruction Author</a></li>
                            <li><a href="{{ route('public.template') }}">Template Word</a></li>
                        </ul>
                    </li>
                    <li><a href="#submission-section">Submission</a></li>
                    <li><a href="#publication-section">Publication</a></li>
                </ul>
            </nav>
            <a href="{{ route('register.index') }}" class="primary-btn top-btn"><i class="fa fa-ticket"></i>
                Register</a>
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>
<!-- Header End -->
