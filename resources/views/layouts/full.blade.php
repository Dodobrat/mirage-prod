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
<div class="preloader"></div>
<div class="pageloader">
    <img class="load-logo" src="{{ \Charlotte\Administration\Helpers\Settings::getFile('pageloader') }}" alt="">
</div>
<div class="nav-container nav-down">
    <nav class="main-nav">
        <div class="custom-container-nav">
            <div class="nav-logo-container">
                <a href="{{ route('index') }}" class="nav-logo redirect">
                    <img id="main-logo" src="{{ asset('/img/MV.png') }}" alt="">
                    <img id="text-logo" src="{{ asset('/img/miragevis.png') }}" alt="">
                </a>
            </div>
            <div class="nav-links-container">
                <a href="{{ route('index') }}" class="nav-link redirect {{ Route::currentRouteNamed('index') ? 'active' : '' }}">{{ trans('front.home') }}</a>
                <a href="{{ route('team.index') }}" class="nav-link redirect {{ Route::currentRouteNamed('team.index') ? 'active' : '' }}">{{ trans('front.team') }}</a>
                <a href="{{ route('contacts.index') }}" class="nav-link redirect {{ Route::currentRouteNamed('contacts.index') ? 'active' : '' }}">{{ trans('front.contact') }}</a>
                @if(!empty(session('workflow_slug')))
                    <a href="{{ route('workflow.index', session('workflow_slug')) }}"
                       class="nav-link redirect {{ Route::currentRouteNamed('workflow.index') ? 'active' : '' }}">{{ trans('front.workflow') }}</a>
                @endif
                <a href="{{ LaravelLocalization::getLocalizedURL('en') }}"
                   class="redirect nav-link @if(App::isLocale('en')) active @endif">{{ trans('front.en') }}</a>
                <a href="{{ LaravelLocalization::getLocalizedURL('fr') }}"
                   class="redirect nav-link @if(App::isLocale('fr')) active @endif">{{ trans('front.fr') }}</a>
            </div>
        </div>
    </nav>
    <div class="secondary-nav">
        <div class="custom-container-nav">
            <div class="collapse show" id="secondary-nav">
                @foreach($types as $type)
                    <a href="{{ route('type.index', [$type->slug] ) }}" class="nav-link redirect">{{ $type->title }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="mobile-nav-container">
    <nav class="navbar fixed-top navbar-expand-xl navbar-light">
        <a class="navbar-brand redirect" href="{{ route('index') }}">
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
                <div class="mx-n3" id="homeOptions">
                    <div class="home-options px-3">
                        <ul class="navbar-nav mr-auto my-2">
                            @foreach($types as $type)
                                <li class="nav-item">
                                    <a href="{{ route('type.index', [$type->slug] ) }}"
                                       class="nav-link redirect">{{ $type->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <li class="nav-item">
                    <a class="nav-link redirect {{ Route::currentRouteNamed('index') ? 'active' : '' }}" href="{{ route('index') }}">{{ trans('front.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link redirect {{ Route::currentRouteNamed('team.index') ? 'active' : '' }}" href="{{ route('team.index') }}">{{ trans('front.team') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link redirect {{ Route::currentRouteNamed('contacts.index') ? 'active' : '' }}" href="{{ route('contacts.index') }}">{{ trans('front.contact') }}</a>
                </li>
                @if(!empty(session('workflow_slug')))
                    <li class="nav-item">
                        <a class="nav-link redirect {{ Route::currentRouteNamed('workflow.index') ? 'active' : '' }}"
                           href="{{ route('workflow.index', session('workflow_slug')) }}">{{ trans('front.workflow') }}</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link redirect @if(App::isLocale('en')) active @endif d-inline-block"
                       href="{{ LaravelLocalization::getLocalizedURL('en') }}">{{ trans('front.en') }}</a> -
                    <a class="nav-link redirect @if(App::isLocale('fr')) active @endif d-inline-block"
                       href="{{ LaravelLocalization::getLocalizedURL('fr') }}">{{ trans('front.fr') }}</a>
                </li>
            </ul>
        </div>
    </nav>
</div>


<div id="content">
    @yield('content')
</div>

<footer>
    <div class="content-container custom-container-nav">
        <div class="row">
            <div class="col-lg-4 col-md-12 footer-field">
                <h4 class="footer-company-name">{{ config('app.name', 'Mirage Visualisation') }}.</h4>
                <p class="copyright mb-0 mt-3">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Mirage Visualisation') }}.
                </p>
                <a href="#" class="copyright mb-0">
                    {{ trans('front.website_by') }}&copy; Charlotte Web Solutions.
                </a>
                <p class="copyright-second">
                    {{ trans('front.rights_reserved') }}
                </p>
            </div>
            <div class="col-lg-4 col-md-12 footer-field">
                <p class="footer-email mb-0">{{ \Charlotte\Administration\Helpers\Settings::get('global_email') }}</p>
                <p class="footer-phone">{{ \Charlotte\Administration\Helpers\Settings::get('global_phone') }}</p>
            </div>
            <div class="col-lg-3 col-md-12 footer-field">
                <div class="row">
                    <div class="col-lg-6 col-md-12 footer-field">
                        <a href="{{ route('index') }}" class="footer-link redirect">{{ trans('front.home') }}</a>
                        <a href="{{ route('team.index') }}" class="footer-link redirect">{{ trans('front.team') }}</a>
                        <a href="{{ route('contacts.index') }}"
                           class="footer-link redirect">{{ trans('front.contact') }}</a>
                    </div>
                    <div class="col-lg-6 col-md-12 footer-field">
                        @if(!empty(route('type.index', ['architecture'])))
                            <a href="{{ route('type.index', ['architecture']) }}"
                               class="footer-link redirect">{{ trans('front.architecture') }}</a>
                        @endif
                        @if(!empty(route('type.index', ['real-estate'])))
                            <a href="{{ route('type.index', ['real-estate']) }}"
                               class="footer-link redirect">{{ trans('front.real_estate') }}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-12 footer-field mt-lg-0 mt-3">
                @if(!empty(\Charlotte\Administration\Helpers\Settings::get('fb_link')))
                    <a href="{{ \Charlotte\Administration\Helpers\Settings::get('fb_link') }}" target="_blank"
                       class="footer-social-link mb-0">{{ trans('front.fb') }}</a>
                @endif
                @if(!empty(\Charlotte\Administration\Helpers\Settings::get('ig_link')))
                    <a href="{{ \Charlotte\Administration\Helpers\Settings::get('ig_link') }}" target="_blank"
                       class="footer-social-link mb-0">{{ trans('front.ig') }}</a>
                @endif
                @if(!empty(\Charlotte\Administration\Helpers\Settings::get('pi_link')))
                    <a href="{{ \Charlotte\Administration\Helpers\Settings::get('pi_link') }}" target="_blank"
                       class="footer-social-link mb-0">{{ trans('front.pin') }}</a>
                @endif
                @if(!empty(\Charlotte\Administration\Helpers\Settings::get('li_link')))
                    <a href="{{ \Charlotte\Administration\Helpers\Settings::get('li_link') }}" target="_blank"
                       class="footer-social-link mb-0">{{ trans('front.lin') }}</a>
                @endif
            </div>
        </div>
    </div>
</footer>

<div class="to-top">
    <div class="up"></div>
</div>

<div class="errors">
    <ol class="errors-list"></ol>
</div>

<div class="success">
    <h5 class="text-center text-white m-0"></h5>
</div>
<div class="loading"></div>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
