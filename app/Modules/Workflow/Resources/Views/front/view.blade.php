@extends('layouts.app')
@section('content')

    <div class="hide-content-container">
        <div class="access-bix">
            <input type="password" name="access_key"
                   id="access_input_{{ $accessed_workflow->slug }}"
                   placeholder="{{ $accessed_workflow->title }}">
            <button type="button"
                    id="access_btn_{{ $accessed_workflow->slug }}">
                Acccess
            </button>
        </div>
    </div>



@endsection

@section('access')
    <script>
        console.log('{{ $accessed_workflow->slug }}');
    </script>
@endsection
