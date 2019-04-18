<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Mirage Visualisation') }}</title>
    <link rel="icon" href="{{ asset('/img/mvTab.png') }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>
<body>
<div class="preloader">
    <div class="loader">
        <span class="loader-block"></span>
        <span class="loader-block"></span>
        <span class="loader-block"></span>
        <span class="loader-block"></span>
        <span class="loader-block"></span>
        <span class="loader-block"></span>
        <span class="loader-block"></span>
        <span class="loader-block"></span>
        <span class="loader-block"></span>
    </div>
</div>
<div class="nav-container nav-down">
    <nav class="main-nav">
        <div class="nav-logo-container">
            <a href="{{ route('index') }}" class="nav-logo">
                <img id="main-logo" src="{{ asset('/img/MV.png') }}" alt="">
                <img id="text-logo" src="{{ asset('/img/miragevis.png') }}" alt="">
            </a>
        </div>
        <div class="nav-links-container">
            <a data-toggle="collapse" href="#secondary-nav" role="button" aria-expanded="@if(Route::currentRouteName() == 'type.index') true @endif" aria-controls="secondary-nav" class="nav-link">{{ trans('front.home') }}</a>
            <a href="{{ route('team.index') }}" class="nav-link">{{ trans('front.team') }}</a>
            <a href="{{ route('contacts.index') }}" class="nav-link">{{ trans('front.contact') }}</a>
            <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="nav-link @if(App::isLocale('en')) active @endif">{{ trans('front.en') }}</a>
            <a href="{{ LaravelLocalization::getLocalizedURL('fr') }}" class="nav-link @if(App::isLocale('fr')) active @endif">{{ trans('front.fr') }}</a>
        </div>
    </nav>
    <div class="secondary-nav">

            <div class="collapse @if(Route::currentRouteName() == 'type.index') show @endif" id="secondary-nav">
                @foreach($types as $type)
                    <a href="{{ route('type.index', [$type->slug] ) }}" class="nav-link">{{ $type->title }}</a>
                @endforeach
            </div>

    </div>
</div>

<div class="mobile-nav-container">
    <nav class="navbar fixed-top navbar-expand-xl navbar-light">
        <a class="navbar-brand" href="{{ route('index') }}">
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
                    <a class="nav-link" data-toggle="collapse" href="#homeOptions" role="button" aria-expanded="false" aria-controls="homeOptions">{{ trans('front.home') }}</a>
                </li>
                <div class="collapse mx-n3" id="homeOptions">
                    <div class="home-options px-3">
                        <ul class="navbar-nav mr-auto my-2">
                            @foreach($types as $type)
                                <li class="nav-item">
                                    <a href="{{ route('type.index', [$type->slug] ) }}" class="nav-link">{{ $type->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('team.index') }}">{{ trans('front.team') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contacts.index') }}">{{ trans('front.contact') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(App::isLocale('en')) active @endif" href="{{ LaravelLocalization::getLocalizedURL('en') }}">{{ trans('front.en') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(App::isLocale('fr')) active @endif" href="{{ LaravelLocalization::getLocalizedURL('fr') }}">{{ trans('front.fr') }}</a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<div id="content" class=" @if(Route::currentRouteName() == 'index') condensed-layout @endif ">
    @yield('content')
</div>

<footer class="@if(Route::currentRouteName() != 'index') mt-5 @endif">
    <div class="content-container">
        <div class="row">
            <div class="col-lg-4 col-md-12 footer-field">
                <h4 class="footer-company-name">{{ config('app.name', 'Mirage Visualisation') }}.</h4>
                <p class="copyright mb-0 mt-3">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Mirage Visualisation') }}.
                </p>
                <p class="copyright mb-0">
                    {{ trans('front.website_by') }}&copy; Charlotte Web Solutions.
                </p>
                <p class="copyright-second">
                    {{ trans('front.rights_reserved') }}
                </p>
            </div>
            <div class="col-lg-4 col-md-12 footer-field">
                <p class="footer-email mb-0">contact@miragevisualisation.com</p>
                <p class="footer-phone">+359897521652</p>
            </div>
            <div class="col-lg-3 col-md-12 footer-field">
                <div class="row">
                    <div class="col-lg-6 col-md-12 footer-field">
                        <a href="{{ route('index') }}" class="footer-link">{{ trans('front.home') }}</a>
                        <a href="{{ route('team.index') }}" class="footer-link">{{ trans('front.team') }}</a>
                        <a href="{{ route('contacts.index') }}" class="footer-link">{{ trans('front.contact') }}</a>
                    </div>
                    <div class="col-lg-6 col-md-12 footer-field">
                        <a href="{{ route('index') }}" class="footer-link">{{ trans('front.architecture') }}</a>
                        <a href="{{ route('index') }}" class="footer-link">{{ trans('front.real_estate') }}</a>
                        <a href="{{ route('index') }}" class="footer-link">{{ trans('front.projects') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-12 footer-field mt-lg-0 mt-3">
                <a href="#" class="footer-social-link mb-0">{{ trans('front.fb') }}</a>
                <a href="#" class="footer-social-link mb-0">{{ trans('front.ig') }}</a>
                <a href="#" class="footer-social-link mb-0">{{ trans('front.pin') }}</a>
                <a href="#" class="footer-social-link mb-0">{{ trans('front.lin') }}</a>
            </div>
        </div>
    </div>
</footer>

<div class="errors">
    <ol class="errors-list"></ol>
</div>

<div class="success">
    <h5 class="text-center text-white m-0"></h5>
</div>

<script src="{{ mix('/js/app.js') }}"></script>
@yield('project')
</body>
</html>
