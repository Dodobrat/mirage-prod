@extends('layouts.app')
@section('content')

    @if(!empty($index))
    <section class="images">
        <div id="scene">
            <img class="bg" data-depth="0.1" src="" alt="">
        </div>
        <div id="filter" @if(!empty( $index->getFirstMediaUrl('filter') ))
        style="background-image: url('{{ $index->getFirstMediaUrl('filter') }}')"
             @else
             style="background-image: none"
            @endif
        ></div>

        <div id="over">
            <img class="grid" @if(!empty($index->getFirstMediaUrl('grid'))) src="{{ $index->getFirstMediaUrl('grid') }}"
                 @else @endif alt="">
        </div>
    </section>
        @else
        <section class="images">
            <div id="scene">
                <img class="bg" data-depth="0.1" src="{{ asset('/img/placeholder.png') }}" alt="">
            </div>
            <div id="filter" style="background-image: none"></div>
            <div id="over">
                <img class="grid" src="" alt="">
            </div>
        </section>
    @endif

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

@if(!empty($index))
@section('random')
    <script>
        let images = [
            @foreach($index->getMedia('background') as $img)
                @if(!empty($img))
                "{{ $img->getUrl('view') }}",
            @endif
            @endforeach
        ];

        function getImageTag() {
            let randomIndex = Math.floor(Math.random() * images.length);
            let img = images[randomIndex];
            let layer = document.querySelector('#scene .bg');
            layer.setAttribute('src', img);
        }

        $(document).ready(function () {
            getImageTag();
        });

    </script>
@endsection
@endif
