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
            <div class="ajax-spinner"></div>
            <div class="ajax-parent-overlay">
                <div class="projects-loader">
                </div>
                <div class="ajax-projects">
                    @include('types::boxes.projects')
                </div>
            </div>
        </div>
    </div>

    {{--PROJECT MODAL--}}
    <div id="my-modal" class="project-modal"></div>


@endsection

@section('projects')
    <script>
        // -----------------------------------------
        //             PROJECTS PAGINATION
        // -----------------------------------------

        let loader = $('.projects-loader');
        let loaderSpin = $('.ajax-spinner');

        let pagination = $('.pagination a');

        pagination.on('click', function (e) {
            e.preventDefault();
            pagination.removeClass('active');
            let activated_page = $(this).addClass('active');
            let clicked_page = activated_page.attr('href').split('page=')[1];
            let url = window.location.href;
            if (url.indexOf('?') > 0) {
                let clean_url = url.substring(0, url.indexOf("?"));
                window.history.replaceState({}, document.title, clean_url);
            }
            let selected_category = $('.categories-items .categories-item.active').data('filter');
            fetchData(clicked_page, selected_category);
        });

        let category = $(".categories-items li");

        category.on('click', function (e) {
            e.preventDefault();
            let category_filter = $(this).data('filter');
            let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?category=' + category_filter;
            window.history.pushState({path: newurl}, '', newurl);
            category.removeClass('active');
            $(this).addClass('active');
            if ($('.pagination .page-item .active').length > 0) {
                let pageNum = 1;
                fetchData(pageNum, category_filter);
            } else {
                let pageNum = 1;
                fetchData(pageNum, category_filter);
            }
        });

        $(document).ready(function () {
            if (window.location.href.indexOf('?category=') > 0) {
                let category_filter = window.location.href.split('category=')[1];
                $('.categories-items li[data-filter="'+ category_filter +'"]').addClass('active');
                let pageNum = 1;
                let target = $('.categories-items li.active');
                $('.categories-items').animate({
                    scrollLeft: $(target).position().left
                }, 1500);
                fetchData(pageNum, category_filter);
            }else{
                $('.categories-items li:first').addClass('active');
            }
        });

        function fetchData(page, cat) {

            let url = '{{ route('type.getProjects') }}';
            let type = '{{ $selected_type->slug }}';
            let projects = $('.ajax-projects');
            let no_projects = `<div class="w-100"><p class="no-projects">{{ trans('types::front.no_projects') }}</h2></div>`;

            $.ajaxSetup({
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'post',
                data: {
                    page: page,
                    category: cat,
                    type: type
                },
                beforeSend: function () {
                    loader.fadeIn();
                    loaderSpin.fadeIn();
                },

                success: function (result) {
                    if (result.errors.length != 0) {
                        loader.fadeOut();
                        $(".errors").fadeIn(200);
                        $('.errors .errors-list').empty();
                        $.each(result.errors, function (key, value) {
                            $('.errors .errors-list').append('<li>' + value + '</li>');
                        });
                        setTimeout(function () {
                            $(".errors").fadeOut(200);
                        }, 5000);
                        loaderSpin.fadeOut();
                    } else {
                        loader.fadeOut();
                        projects.html(result.projects_grid);

                        $(function () {
                            $('.gallery-item > .gallery-card').hoverdir();
                        });
                        if ($('.ajax-projects .row.align-items-center .gallery-item').length < 1) {

                            projects.html(no_projects);
                        }

                        loaderSpin.fadeOut();

                        let pagination = $('.pagination a');
                        pagination.on('click', function (e) {
                            e.preventDefault();
                            pagination.removeClass('active');
                            let activated_page = $(this).addClass('active');
                            let clicked_page = activated_page.attr('href').split('page=')[1];
                            let selected_category = $('.categories-items .categories-item.active').data('filter');
                            fetchData(clicked_page, selected_category);
                        });
                    }
                }
            });
        }

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
                    $('.loading').slideDown(500);
                },

                success: function (result) {
                    if (result.errors.length != 0) {
                        $('.loading').slideUp(500);
                        $(".errors").fadeIn(200);
                        $('.errors .errors-list').empty();
                        $.each(result.errors, function (key, value) {
                            $('.errors .errors-list').append('<li>' + value + '</li>');
                        });
                        setTimeout(function () {
                            $(".errors").fadeOut(200);
                        }, 5000);
                    } else {
                        let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?project=' + projectId;
                        window.history.pushState({path: newurl}, '', newurl);
                        $modal.fadeIn(300);
                        // $('body').css('overflowY', 'hidden');
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
            let url = window.location.href;
            if (url.indexOf('?') > 0) {
                let clean_url = url.substring(0, url.indexOf("?"));
                window.history.replaceState({}, document.title, clean_url);
            }
            $modal.fadeOut(300);
            $('.loading').slideUp(500);
            // $('body').css('overflowY', 'auto');
        }

        $(document).ready(function () {
            if (window.location.href.indexOf('?project=') > 0) {
                let projectId = window.location.href.split('project=')[1];
                openModal(projectId);
            }
        });

    </script>
@endsection


