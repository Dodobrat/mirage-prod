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
            @include('types::boxes.projects')
        </div>
        {{--        {{ $projects->links() }}--}}
        {{--        @include('types::boxes.pagination', ['paginator' => $projects, 'type' => $selected_type])--}}
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
        //
        // function getCurrentPageNumber(){
        //     return $('.pagination .active a').attr('href').split('page=')[1];
        // }
        //
        // function getClickedPageNumber(){
        //     let page = $('.pagination a');
        //     page.click(function (e) {
        //         e.preventDefault();
        //         let current_page = $(this).attr('href').split('page=')[1];
        //     });
        //     return current_page;
        // }
        //
        //
        // console.log(getCurrentPageNumber());
        //
        // let category = $(".categories-items li");
        // let active_category = category.first().trigger("click").addClass('active').data('filter');
        //
        // category.click(function () {
        //     let category_filter = $(this).data('filter');
        //     category.removeClass('active');
        //     $(this).addClass('active');
        // });
        //
        // function getData() {
        //
        //     console.log();
        // }

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


