@extends('layouts.full')
@section('content')
    <div class="custom-container-content">
        {{--    SELECTED PROJECT TYPE--}}
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <div class="selected">
                        <p>{{ $selected_type->title }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{--CUSTOM PROJECTS CONTAINER--}}
        <div class="custom-projects-container">
            {{--PROJECT CATEGORIES--}}
            <ul class="categories-items">
                <li data-filter="all" class="categories-item">
                    <button class="categories-item-link">{{ trans('types::front.all') }}</button>
                </li>
                @foreach($categories as $category)
                    <li data-filter="{{ $category->slug }}" class="categories-item">
                        <button class="categories-item-link">{{ $category->title }}</button>
                    </li>
                @endforeach
            </ul>

            <div class="divider">
                <div class="line"></div>
            </div>

            {{--PROJECT GRID--}}
            <div class="ajax-projects" data-url="{{ route('type.getProjects') }}"
                 data-type="{{ $selected_type->slug }}">
                @include('types::boxes.projects')
            </div>
        </div>
    </div>

    <div class="load-more-projects-loader">
        <img class="ajax-load-logo" src="{{ \Charlotte\Administration\Helpers\Settings::getFile('pageloader') }}">
    </div>
    {{--PROJECT MODAL--}}
    <div id="my-modal" class="project-modal"></div>
@endsection


