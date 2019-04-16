@extends('layouts.app')
@section('content')

    <div class="custom-wide-container">
        <div class="row py-5">
            <div class="col-lg-5 col-md-12 col-sm-12 col-12 contact-details px-3 pt-lg-3 pr-lg-5">
                @foreach($contacts as $contact)
                    <h1 class="contact-heading">
                        {{ $contact->title }}
                    </h1>
                    <div class="contact-description">
                        {!! $contact->description !!}
                    </div>

                    <h6 class="contact-detail address">
                        {{ trans('contacts::front.address') }}
                        <span>{{ $contact->address }}</span>
                    </h6>

                    <h6 class="contact-detail phone">
                        {{ trans('contacts::front.phone') }}
                        <span>{{ $contact->phone }}</span>
                    </h6>
                    <h6 class="contact-detail email">
                        {{ trans('contacts::front.email') }}
                        <span>{{ $contact->email }}</span>
                    </h6>
                @endforeach
            </div>
            <div class="col-lg-7 col-md-12 col-sm-12 col-12 contact-form-section pl-lg-5 px-3">
                @foreach($contacts as $contact)
                    <form class="contact-email-form"
                          method="POST"
                          action="{{ route('contacts.store') }}"
                          data-url="{{ route('contacts.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="contact-name-field {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <input class="field name"
                                           id="name_{{ $contact->id }}"
                                           type="text"
                                           name="name"
                                           placeholder="{{ trans('contacts::front.name') }}"
                                           required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="contact-email-field {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input class="field email"
                                           id="email_{{ $contact->id }}"
                                           type="email"
                                           name="email"
                                           placeholder="{{ trans('contacts::front.contact_email') }}"
                                           required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div
                                    class="contact-subject-field {{ $errors->has('subject') ? ' has-error' : '' }}">
                                    <input class="field subject"
                                           id="subject_{{ $contact->id }}"
                                           type="text"
                                           name="subject"
                                           placeholder="{{ trans('contacts::front.subject') }}"
                                           required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div
                                    class="contact-comment-field {{ $errors->has('comment') ? ' has-error' : '' }}">
                            <textarea class="comment"
                                      id="comment_{{ $contact->id }}"
                                      type="text"
                                      name="comment"
                                      placeholder="{{ trans('contacts::front.comment') }}"
                                      required></textarea>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="contact_id" value="{{ $contact->id }}">

                        <button type="button"
                                class="submit-btn"
                                id="ajaxSubmitCon_{{$contact->id}}">
                            {{trans('contacts::front.send')}}
                        </button>

                    </form>
                @endforeach
            </div>
            @if(!empty($contacts->first()) && $contacts->first()->show_map == 1)
                <div class="col-12 contact-map mt-5 pt-lg-5 pt-0">
                    <div id="map"></div>
                </div>
            @endif
        </div>
    </div>


@endsection


