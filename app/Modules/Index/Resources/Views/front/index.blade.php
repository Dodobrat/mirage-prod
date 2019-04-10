@extends('layouts.app')
@section('content')


@foreach($types as $type)

    <a href="{{ route('type', [$type->slug] ) }}">{{ $type->title }}</a>

@endforeach


@endsection
