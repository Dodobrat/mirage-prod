@extends('layouts.full')
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
                   value="@if(!empty(session('access_key'))) {{ session('access_key') }}@endif"
                   placeholder="{{ $accessed_workflow->title }}">
            <button type="button"
                    class="access-btn"
                    onclick="getWorkflow( '{{ $accessed_workflow->id }}','{{ $accessed_workflow->slug }}','{{ route('workflow.getWorkflow') }}')">
                {{ trans('front.access') }}
            </button>
        </div>
    </div>

    <div id="workflow_content"></div>

@endsection
