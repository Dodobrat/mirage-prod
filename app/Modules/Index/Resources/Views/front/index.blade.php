@extends('layouts.app')
@section('content')

{{--    SELECTED PROJECT TYPE--}}
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12">
                <div class="selected-type">
                    <p>Architecture</p>
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

<div class="test-text 2">
    askjnladsc
</div>

<div class="test-text 1">
    az
</div>

<div class="test-text 4">
    ti
</div>




















{{--CUSTOM PROJECTS CONTAINER--}}
    <div class="custom-projects-container">
        <div class="row align-items-center">

            <div class="col-lg-3 col-md-4 col-sm-6 col-6 p-1 gallery-item">

                <div class="gallery-card">
                    <a id="modal-btn" class="project-modal-btn">
                        <img data-tags="Animators,Illustrators" src="https://via.placeholder.com/150" alt="" class="gallery-item-img w-100">
                    </a>
                    <div class="overlay">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="overlay-title">
                                    something
                                </h3>
                            </div>
                            <div class="col-12">
                                <p class="overlay-text">
                                    else
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>


{{--PROJECT MODAL--}}
    <div id="my-modal" class="project-modal">
        <div class="project-modal-content">

            <div class="project-modal-header">
                <div class="row align-items-center">
                    <div class="col-lg-11 col-md-11 col-sm-10 col-10">
                        <h5 class="project-modal-title">This is Title - <span class="project-modal-project">This is project</span></h5>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2 col-2 text-right">
                        <button class="project-modal-close-btn">
                            <img src="{{ asset('/img/x.svg') }}" alt="">
                        </button>
                    </div>
                </div>
            </div>

            <div class="project-modal-body">
                <div id="projectCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#projectCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#projectCarousel" data-slide-to="1"></li>
                        <li data-target="#projectCarousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://via.placeholder.com/350" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/450" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://via.placeholder.com/250" alt="...">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#projectCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#projectCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

        </div>
    </div>



@endsection
