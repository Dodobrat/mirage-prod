@extends('layouts.app')
@section('content')

    <div class="landing-container">
        <img class="overlay-grid" src="{{ asset('/img/mirage_grid_smaller.png') }}" alt="">
    </div>

    <div class="type-selection-container">
        @foreach($types as $type)

            <a class="type-btn-link redirect" href="{{ route('type.index', [$type->slug] ) }}">
                <button class="type-btn">
                    {{ $type->title }}
                </button>
            </a>

        @endforeach

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
