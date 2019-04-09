<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Mirage Visualisation') }}</title>
        <link rel="icon" href="{{ asset('/img/mvTab.png') }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>
<body>

<div class="nav-container nav-down">
    <nav class="main-nav">
        <div class="nav-logo-container">
            <a href="#" class="nav-logo">
                <img id="main-logo" src="{{ asset('/img/MV.png') }}" alt="">
                <img id="text-logo" src="{{ asset('/img/miragevis.png') }}" alt="">
            </a>
        </div>
        <div class="nav-links-container">
            <a data-toggle="collapse" href="#secondary-nav" role="button" aria-expanded="true" aria-controls="secondary-nav" class="nav-link">Home</a>
            <a href="#" class="nav-link">Team</a>
            <a href="#" class="nav-link">Contact</a>
            <a href="#" class="nav-link">EN</a>
            <a href="#" class="nav-link">FR</a>
        </div>
    </nav>
    <div class="secondary-nav">
        <div class="collapse show" id="secondary-nav">
            <a href="#" class="nav-link">Architecture</a>
            <a href="#" class="nav-link">Real Estate</a>
        </div>
    </div>
</div>

<div class="mobile-nav-container">
    <nav class="navbar fixed-top navbar-expand-xl navbar-light">
        <a class="navbar-brand" href="#">
            <img id="mobile-main-logo" src="{{ asset('/img/MV.png') }}" alt="">
        </a>
        <button class="navbar-toggler collapsed"
                id="mobile-nav-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarExpand"
                aria-controls="navbarExpand"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <div id="hamburger">
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </button>

        <div class="collapse navbar-collapse" id="navbarExpand">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#homeOptions" role="button" aria-expanded="false" aria-controls="homeOptions">Home</a>
                </li>
                <div class="collapse mx-n3" id="homeOptions">
                    <div class="home-options px-3">
                        <ul class="navbar-nav mr-auto my-2">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Architecture</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Real Estate</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <li class="nav-item">
                    <a class="nav-link" href="#">Team</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">EN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FR</a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<div id="content">
    @yield('content')
</div>

<footer class="mt-5">
    <div class="content-container">
        <div class="row">
            <div class="col-lg-4 col-md-12 footer-field">
                <h4 class="footer-company-name">{{ config('app.name', 'Mirage Visualisation') }}.</h4>
                <p class="copyright mb-0 mt-3">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Mirage Visualisation') }}.
                </p>
                <p class="copyright-second">
                    All rights reserved.
                </p>
            </div>
            <div class="col-lg-4 col-md-12 footer-field">
                <p class="footer-email mb-0">contact@miragevisualisation.com</p>
                <p class="footer-phone">+359897521652</p>
            </div>
            <div class="col-lg-3 col-md-12 footer-field">
                <div class="row">
                    <div class="col-lg-6 col-md-12 footer-field">
                        <a href="#" class="footer-link">Home</a>
                        <a href="#" class="footer-link">The team</a>
                        <a href="#" class="footer-link">Contact</a>
                    </div>
                    <div class="col-lg-6 col-md-12 footer-field">
                        <a href="#" class="footer-link">Architecture</a>
                        <a href="#" class="footer-link">Real Estate</a>
                        <a href="#" class="footer-link">Projects</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-12 footer-field mt-lg-0 mt-3">
                <a href="#" class="footer-social-link mb-0">Facebook</a>
                <a href="#" class="footer-social-link mb-0">Instagram</a>
                <a href="#" class="footer-social-link mb-0">Pinterest</a>
                <a href="#" class="footer-social-link mb-0">LinkedIn</a>
            </div>
        </div>
    </div>
</footer>

<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>