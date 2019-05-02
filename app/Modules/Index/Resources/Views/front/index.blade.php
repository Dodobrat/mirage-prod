@extends('layouts.app')
@section('content')

<section class="images">
    <div id="scene">
        <img class="bg" data-depth="0.05" src="{{ \Charlotte\Administration\Helpers\Settings::getFile('index_bg','thumb') }}" alt="">
    </div>
    <div id="filter"></div>
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

@endsection
