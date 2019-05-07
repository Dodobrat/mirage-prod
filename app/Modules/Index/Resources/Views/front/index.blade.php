@extends('layouts.app')
@section('content')

    <section class="images">
        <div id="scene">
            @if(!empty(\Charlotte\Administration\Helpers\Settings::getFile('index_bg','thumb')))
                <img class="bg" data-depth="0.05"
                     src="{{ \Charlotte\Administration\Helpers\Settings::getFile('index_bg','thumb') }}" alt="">
            @else
                <img class="bg" data-depth="0.05"
                     src="{{ asset('/img/placeholder.png') }}" alt="">
            @endif
        </div>
        <div id="filter"
             style="background-image: url('{{ \Charlotte\Administration\Helpers\Settings::getFile('index_filter') }}')"></div>
        <div id="over">
            <img class="grid" src="{{ \Charlotte\Administration\Helpers\Settings::getFile('index_grid') }}" alt="">
        </div>
    </section>

    <div class="type-selection-container">
        <div class="custom-content">

            @foreach($types as $type)

                <a class="type-btn-link redirect" href="{{ route('type.index', [$type->slug] ) }}">
                    <button class="type-btn">
                        {{ $type->title }}
                    </button>
                </a>

            @endforeach

        </div>
    </div>

    @if($types->count() > 1)
        <div class="placement">
            <div class="containment">
                <div class="block">
                    <div class="inner-color"></div>
                </div>
                <div class="block right">
                    <div class="inner-color"></div>
                </div>
                <div class="block">
                    <div class="inner-color"></div>
                </div>
                <div class="block right">
                    <div class="inner-color"></div>
                </div>
            </div>
        </div>
    @endif

@endsection
