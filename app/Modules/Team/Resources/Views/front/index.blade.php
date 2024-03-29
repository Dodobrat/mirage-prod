@extends('layouts.full')
@section('content')
    <div class="custom-container-content">

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <div class="selected">
                        <p>{{ trans('team::front.team') }}</p>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 page-desc text-center pt-5">
                    @if(!empty($block->where('key','member_about')->first()))
                        {!! $block->where('key','member_about')->first()->description !!}
                    @endif
                </div>
            </div>
        </div>

    </div>

    <div class="members-grid-container">
        <div class="row custom-container-nav">
            @foreach($members as $member)
                <div class="col-lg-3 col-md-4 col-sm-6 col-6 px-1 member-col">
                    <div class="member-card-container">
                        <div class="member-img-container">
                            @if(!empty($member->getFirstMedia('photo')))
                                <img src="{{ $member->getFirstMedia('photo')->getUrl('thumb') }}" alt=""
                                     class="member-photo">
                            @else
                                <img src="{{ asset('/img/placeholder.png') }}" alt="" class="member-photo">
                            @endif
                        </div>
                        <div class="member-info px-3">
                            <h6 class="member-name">{{ $member->name }}</h6>
                            <p class="member-position">{{ $member->position }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="custom-container-content py-3">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-12 py-3 text-center">
                    <p class="need-project">
                        {{ trans('team::front.need_project') }}
                    </p>
                </div>
                <div class="col-lg-7 col-md-12 page-contact text-center py-4">
                    @if(!empty($block->where('key','need_project')->first()))
                        {!! $block->where('key','need_project')->first()->description !!}
                    @endif
                </div>
                <div class="col-12 text-center">
                    <a href="{{ route('contacts.index') }}" class="redirect">
                        <button class="talk">
                            {{ trans('team::front.talk') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
