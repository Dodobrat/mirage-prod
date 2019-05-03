@extends('layouts.app')
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

            <ul class="categories-items">
                <li data-filter="all" class="categories-item active">
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


            <div class="row align-items-center ajax-projects">
                @include('types::boxes.projects')
            </div>
            <div class="pagination-container">
                @include('types::boxes.pagination', ['projects' => $projects])
{{--                {{ $projects->links() }}--}}
            </div>

        </div>
    </div>


    {{--PROJECT MODAL--}}
    <div id="my-modal" class="project-modal">

    </div>



@endsection

@section('projects')
    <script>
        // -----------------------------------------
        //             PROJECTS PAGINATION
        // -----------------------------------------

        $(document).ready(function () {

            let pagination = $('.pagination a');

            pagination.on('click',function (e) {
                e.preventDefault();
                pagination.removeClass('active');
                let activated_page = $(this).addClass('active');
                let clicked_page = activated_page.attr('href').split('page=')[1];
                let selected_category = $('.categories-items .categories-item.active').data('filter');
                fetchData(clicked_page, selected_category);
            });

            $('.cover-up').hide();
            $('.gallery-item:hidden').show().removeClass('hidden');

            let category = $(".categories-items li");

            category.on('click',function (e) {
                e.preventDefault();
                let category_filter = $(this).data('filter');
                category.removeClass('active');
                $(this).addClass('active');
                let pageNum = $('.pagination .page-item .active').attr('href').split('page=')[1];
                fetchData(pageNum, category_filter);
            });

            function fetchData(page, cat) {

                let url = '{{ route('type.getProjects') }}';
                let type = '{{ $selected_type->slug }}';
                let projects = $('.ajax-projects');
                let pagination = $('.pagination-container');


                $.ajaxSetup({
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    method: 'get',
                    data: {
                        page: page,
                        category: cat,
                        type: type
                    },
                    beforeSend: function () {
                        $('.loader-container').show();
                    },

                    success: function (result) {
                        if (result.errors.length != 0) {
                            $('.loader-container').hide();
                            $(".errors").fadeIn(200);
                            $('.errors .errors-list').empty();
                            $.each(result.errors, function (key, value) {
                                $('.errors .errors-list').append('<li>' + value + '</li>');
                            });
                            setTimeout(function () {
                                $(".errors").fadeOut(200);
                            }, 5000);
                        } else {
                            $('.loader-container').hide();

                            projects.html(result.projects_grid);
                            $(function () {
                                $('.gallery-item > .gallery-card').hoverdir();
                            });
                        }
                    }
                });
            }
        });

    </script>
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
        function openModal(id, slug) {
            let projectId = id;
            let projectUrl = '{{ route('projects.getProject') }}';
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
                    $('.loader-container').show();
                },

                success: function (result) {
                    if (result.errors.length != 0) {
                        $('.loader-container').hide();
                        $(".errors").fadeIn(200);
                        $('.errors .errors-list').empty();
                        $.each(result.errors, function (key, value) {
                            $('.errors .errors-list').append('<li>' + value + '</li>');
                        });
                        setTimeout(function () {
                            $(".errors").fadeOut(200);
                        }, 5000);
                    } else {
                        $('.loader-container').hide();
                        $modal.fadeIn(300);
                        $('body').css('overflowY', 'hidden');
                        $modal.html(result.project_modal);
                        let images = document.querySelectorAll(".lazy-load");
                        for (let i = 0; i < images.length; i++) {
                            images[i].src = images[i].getAttribute('data-src');
                        }
                        $(document).keyup(function (e) {
                            if (e.keyCode === 27) {
                                closeModal();
                            }
                            if (e.keyCode === 37) {
                                $('a.carousel-control-prev').trigger('click');
                            }
                            if (e.keyCode === 39) {
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
            $('body').css('overflowY', 'auto');
        }
    </script>
@endsection


