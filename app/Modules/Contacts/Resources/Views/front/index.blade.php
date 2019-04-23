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
            <div class="col-lg-7 col-md-12 col-sm-12 col-12 contact-form-section pl-lg-5 px-3 pt-lg-0 pt-5">
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
                                <div class="contact-subject-field {{ $errors->has('subject') ? ' has-error' : '' }}">
                                    <input class="field subject"
                                           id="subject_{{ $contact->id }}"
                                           type="text"
                                           name="subject"
                                           placeholder="{{ trans('contacts::front.subject') }}"
                                           required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact-comment-field {{ $errors->has('comment') ? ' has-error' : '' }}">
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
            <div class="col-12">
                <p class="curr-time">current time in your country <span class="clock"></span></p>
                <p class="our-time">current time in our country <span class="our-clock"></span></p>
            </div>
            @if(!empty($contacts->first()) && $contacts->first()->show_map == 1)
                <div class="col-12 contact-map mt-5 pt-lg-5 pt-0">
                    <div id="map"></div>
                    <script>
                        function initMap() {
                            let destination = {
                                lat: parseFloat("{{ $contact->first()->lat }}"),
                                lng: parseFloat("{{ $contact->first()->lng }}")
                            };
                            let options = {
                                zoom: 16,
                                center: destination,
                                styles: [
                                    {
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#f5f5f5"
                                            }
                                        ]
                                    },
                                    {
                                        "elementType": "labels.icon",
                                        "stylers": [
                                            {
                                                "visibility": "off"
                                            }
                                        ]
                                    },
                                    {
                                        "elementType": "labels.text.fill",
                                        "stylers": [
                                            {
                                                "color": "#616161"
                                            }
                                        ]
                                    },
                                    {
                                        "elementType": "labels.text.stroke",
                                        "stylers": [
                                            {
                                                "color": "#f5f5f5"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "administrative",
                                        "elementType": "geometry.stroke",
                                        "stylers": [
                                            {
                                                "color": "#808080"
                                            },
                                            {
                                                "visibility": "on"
                                            },
                                            {
                                                "weight": 1
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "administrative.land_parcel",
                                        "elementType": "labels",
                                        "stylers": [
                                            {
                                                "visibility": "off"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "administrative.land_parcel",
                                        "elementType": "labels.text.fill",
                                        "stylers": [
                                            {
                                                "color": "#bdbdbd"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "landscape",
                                        "elementType": "geometry.stroke",
                                        "stylers": [
                                            {
                                                "color": "#808080"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "poi",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#eeeeee"
                                            },
                                            {
                                                "visibility": "off"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "poi",
                                        "elementType": "labels.text",
                                        "stylers": [
                                            {
                                                "visibility": "off"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "poi",
                                        "elementType": "labels.text.fill",
                                        "stylers": [
                                            {
                                                "color": "#757575"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "poi.park",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#e5e5e5"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "poi.park",
                                        "elementType": "labels.text.fill",
                                        "stylers": [
                                            {
                                                "color": "#9e9e9e"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "road",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#ffffff"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "road",
                                        "elementType": "geometry.stroke",
                                        "stylers": [
                                            {
                                                "color": "#c0c0c0"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "road.arterial",
                                        "elementType": "labels.text.fill",
                                        "stylers": [
                                            {
                                                "color": "#757575"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "road.highway",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#dadada"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "road.highway",
                                        "elementType": "labels.text.fill",
                                        "stylers": [
                                            {
                                                "color": "#616161"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "road.local",
                                        "elementType": "labels",
                                        "stylers": [
                                            {
                                                "visibility": "off"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "road.local",
                                        "elementType": "labels.text.fill",
                                        "stylers": [
                                            {
                                                "color": "#9e9e9e"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "transit",
                                        "elementType": "geometry.stroke",
                                        "stylers": [
                                            {
                                                "color": "#808080"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "transit.line",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#e5e5e5"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "transit.station",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#eeeeee"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "water",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#c9c9c9"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "water",
                                        "elementType": "labels.text.fill",
                                        "stylers": [
                                            {
                                                "color": "#9e9e9e"
                                            }
                                        ]
                                    }
                                ],
                                mapTypeControlOptions: {
                                    mapTypeIds: ['roadmap', 'styled_map']
                                },
                            };
                            map = new google.maps.Map(document.getElementById('map'), options);
                            let marker = new google.maps.Marker({
                                position: {
                                    lat: parseFloat("{{ $contact->first()->lat }}"),
                                    lng: parseFloat("{{ $contact->first()->lng }}")
                                },
                                map: map,
                            });

                            let infoWindow = new google.maps.InfoWindow({
                                content: `
               <p style="padding: 10px;
                        margin: 0;
                        font-size: 18px;
                        text-transform: uppercase;
                        font-weight: 400;">
                    {!! $contact->first()->working_time  !!}
                                    </p>
`
                            });

                            marker.addListener('click', function () {
                                infoWindow.open(map, marker);
                            });
                            window.addEventListener('load',function () {
                                infoWindow.open(map, marker);
                            })


                        }
                    </script>
                    <script async defer
                            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKhdWL4CSF76doFX87HniGdtw53XExa34&callback=initMap"
                            type="text/javascript"></script>
                </div>
            @endif
        </div>
    </div>


@endsection


