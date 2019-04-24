@extends('layouts.app')
@section('content')

    <div class="hide-content-container"
         @if(!empty($accessed_workflow->getFirstMedia('access')))
         style="background-image: url('{{ $accessed_workflow->getFirstMedia('access')->getUrl() }}')"
         @else
         style="background-image: url('{{ asset('img/mirage_grid_smaller.png') }}')"
        @endif>
        <div class="access-box">
            <input type="password"
                   name="access_key"
                   class="access-input"
                   id="access_input_{{ $accessed_workflow->slug }}"
                   value="@if(!empty(session('access_key'))) {{ session('access_key') }}@endif"
                   placeholder="{{ $accessed_workflow->title }}">
            <button type="button"
                    class="access-btn"
                    id="access_btn_{{ $accessed_workflow->slug }}"
                    onclick="getWorkflow( '{{ $accessed_workflow->id }}','{{ route('workflow.getWorkflow') }}','{{ $accessed_workflow->slug }}')">
                {{ trans('front.access') }}
            </button>
        </div>
    </div>

    <div id="workflow_content"></div>

@endsection

@section('access')
    <script>
        // -----------------------------------------
        //             WORKFLOW ACCESS
        // -----------------------------------------

        let workflowContent = document.querySelector('#workflow_content');
        let contentHider = document.querySelector('.hide-content-container');

        function getWorkflow(id, url, slug) {
            let workflowId = id;
            let workflowUrl = url;
            let workflowSlug = slug;
            let accessKey = document.querySelector('#access_input_{{ $accessed_workflow->slug }}').value;

            $.ajaxSetup({
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: workflowUrl,
                method: 'post',
                data: {
                    workflow_id: workflowId,
                    access_key: accessKey,
                    workflow_slug: workflowSlug,
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
                        $(contentHider).fadeOut(300);
                        workflowContent.innerHTML = result.workflow_content;
                        setTimeout(function () {
                            $(workflowContent).fadeIn(500);
                        }, 350);
                    }
                }
            });
        }

    </script>
@endsection
