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

    <ul id="test">
        <li data-filter="1">OP1</li>
        <li data-filter="2">OP2</li>
        <li data-filter="3">OP3</li>
        <li data-filter="4">OP4</li>
    </ul>




    {{--CUSTOM PROJECTS CONTAINER--}}


    <div class="custom-projects-container">
        <div class="row align-items-center">
            @foreach($projects as $project)
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 p-1 gallery-item 1">

                <div class="gallery-card">
                    <a id="modal-btn" class="project-modal-btn">
                        <img data-tags="Animators,Illustrators" src="{{ $project->getFirstMedia('media')->getUrl('thumb') }}" alt="" class="gallery-item-img">
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
