@extends('layouts.app')
@section('content')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 py-5">
                <div class="page-name">
                    <p>{{ trans('team::front.team') }}</p>
                </div>
            </div>
            <div class="col-lg-7 col-md-12 page-desc text-center">
                <p>{{ trans('team::front.description') }}</p>
            </div>
        </div>
    </div>

    <div class="members-grid-container">
        <div class="row justify-content-center">
            @foreach($members as $member)
                <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-1">
                    <div class="member-card-container">
                        <div class="member-img-container">
                            @if(!empty($member->getFirstMedia('photo')))
                                <img src="{{ $member->getFirstMedia('photo')->getUrl() }}" alt=""
                                     class="member-photo">
                            @else
                                <img src="#" alt="" class="member-photo">
                            @endif
                            @if(!empty($member->getFirstMedia('illustration')))
                                <img src="{{ $member->getFirstMedia('illustration')->getUrl() }}" alt=""
                                     class="member-illustration">
                            @else
                                <img src="#" alt="" class="member-illustration">
                            @endif
                        </div>
                        <div class="member-info px-2">
                            <h6 class="member-name">{{ $member->name }}</h6>
                            <p class="member-position">{{ $member->position }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12 py-3 text-center">
                <h4 class="need-project">
                    {{ trans('team::front.need_project') }}
                </h4>
            </div>
            <div class="col-lg-7 col-md-12 page-desc text-center py-4">
                <p>
                    {{ trans('team::front.description') }}
                </p>
            </div>
            <div class="col-12 text-center">
                <a href="{{ route('contacts.index') }}" class="talk redirect">
                    {{ trans('team::front.talk') }}
                </a>
            </div>
        </div>
    </div>

@endsection
