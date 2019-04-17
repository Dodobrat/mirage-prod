@extends('layouts.app')
@section('content')

    {{--    SELECTED PROJECT TYPE--}}
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12">
                <div class="selected-type">
                    <p>{{ $selected_type->title }}</p>
                </div>
            </div>
        </div>
    </div>


    {{--FILTERS TABS--}}

    {{--    <ul id="test">--}}
    {{--        <li data-filter="">All</li>--}}
    {{--        @foreach($selected_type->categories as $category)--}}

    {{--            <li data-filter="{{ $category->slug }}">{{ $category->title }}</li>--}}

    {{--        @endforeach--}}
    {{--    </ul>--}}





    {{--CUSTOM PROJECTS CONTAINER--}}


    <div class="custom-projects-container">

        <ul class="categories-items">
            <li data-filter="" class="categories-item">
                <a class="categories-item-link">{{ trans('types::front.all') }}</a>
            </li>
            @foreach($selected_type->categories as $category)
                <li data-filter="{{ $category->slug }}" class="categories-item">
                    <a class="categories-item-link">{{ $category->title }}</a>
                </li>
            @endforeach
        </ul>

        <div class="divider">
            <div class="line"></div>
        </div>


        <div class="row align-items-center">
            @foreach($projects as $project)
                <div class="col-lg-3 col-md-4 col-sm-6 col-6 p-1 gallery-item {{ $project->category->slug }}">

                    <div class="gallery-card">
                        <a id="modal-btn"
                           class="project-modal-btn">
                            @if(!empty($project->getFirstMedia('media')))
                                <img data-tags="smth" src="{{ $project->getFirstMedia('media')->getUrl('thumb') }}"
                                     alt="" class="gallery-item-img">
                            @else
                                <img data-tags="sad" src="#" alt="ghjkjk" class="gallery-item-img">
                            @endif
                        </a>
                        <div class="overlay">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="overlay-title">
                                        {{ $project->title }}
                                    </h4>
                                </div>
                                <div class="col-12">
                                    <p class="overlay-text">
                                        {{ $project->architect }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            @endforeach

        </div>
    </div>


    {{--PROJECT MODAL--}}
    <div id="my-modal" class="project-modal">
        @include('projects::boxes.project')
    </div>



@endsection
