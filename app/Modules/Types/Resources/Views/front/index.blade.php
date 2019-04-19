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

    {{--CUSTOM PROJECTS CONTAINER--}}
    <div class="custom-projects-container">

        <ul class="categories-items">
            <li data-filter="" class="categories-item">
                <button class="categories-item-link">{{ trans('types::front.all') }}</button>
            </li>
            @foreach($selected_type->categories as $category)
                <li data-filter="{{ $category->slug }}" class="categories-item">
                    <button class="categories-item-link">{{ $category->title }}</button>
                </li>
            @endforeach
        </ul>

        <div class="divider">
            <div class="line"></div>
        </div>


        <div class="row align-items-center">
{{--            <div class="cover-up"></div>--}}
            @foreach($projects as $project)
                <div class="col-lg-3 col-md-4 col-sm-6 col-6 p-1 gallery-item {{ $project->category->slug }}">

                    <div class="gallery-card">
                        <button id="modal-btn"
                           onclick="openModal( '{{ $project->id }}','{{ route('projects.getProject') }}','{{ $project->slug }}')"
                           class="project-modal-btn">
                            @if(!empty($project->getFirstMedia('media')))
                                <img src="{{ $project->getFirstMedia('media')->getUrl('thumb') }}"
                                     alt="" class="gallery-item-img">
                            @else
                                <img src="#" alt="" class="gallery-item-img">
                            @endif
                        </button>
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
{{--        {{ $projects->links() }}--}}
    </div>


    {{--PROJECT MODAL--}}
    <div id="my-modal" class="project-modal">
        @include('projects::boxes.project')
    </div>



@endsection

@section('project')
    <script>
        // -----------------------------------------
        //             PROJECT MODAL
        // -----------------------------------------

        let $modal = $('#my-modal');
        let $modalContent = $('.project-modal-content');
        let $modalBtn = $('#modal-btn');
        let $closeBtn = $('.project-modal-close-btn');

        // Open
        function openModal(id, url, slug) {
            let projectId = id;
            let projectUrl = url;
            $.ajaxSetup({
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: projectUrl,
                method: 'post',
                data: {
                    project_id: projectId,
                },
                beforeSend: function () {
                    // $(".aspin").show();
                },

                success: function (result) {
                    if (result.errors.length != 0) {
                        // $(".aspin").hide();
                        $(".errors").fadeIn(200);
                        $('.errors .errors-list').empty();
                        $.each(result.errors, function (key, value) {
                            $('.errors .errors-list').append('<li>' + value + '</li>');
                        });
                        setTimeout(function(){
                            $(".errors").fadeOut(200);
                        }, 5000);
                    } else {
                        // $(".aspin").hide();
                        $modal.fadeIn(300);
                        $('body').css('overflowY','hidden');
                        $modal.html(result.project_modal);
                        $(document).keyup(function(e) {
                            if (e.keyCode === 27){
                                closeModal();
                            }
                            if (e.keyCode === 37){
                                $('a.carousel-control-prev').trigger('click');
                            }
                            if (e.keyCode === 39){
                                $('a.carousel-control-next').trigger('click');
                            }

                        });
                    }
                }
            });
        }

        // Close
        function closeModal() {
            $modal.fadeOut(300);
            $('body').css('overflowY','auto');
        }
    </script>
@endsection
