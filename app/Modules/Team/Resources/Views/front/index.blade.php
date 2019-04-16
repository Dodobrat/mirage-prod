@extends('layouts.app')
@section('content')


    @foreach($members as $member)
        
        <p>{{ $member->name }}</p>
        <p>{{ $member->position }}</p>
{{--        <img src="{{ $member->getFirstMedia('photo')->getUrl('thumb') }}" alt="">--}}
{{--        <img src="{{ $member->getFirstMedia('illustration')->getUrl('thumb') }}" alt="">--}}

    @endforeach

@endsection
