@if(!empty($project))
    <div class="project-modal-content">

        <div class="project-modal-header">
            <div class="row align-items-center">
                <div class="col-lg-11 col-md-11 col-sm-10 col-10">
                    <h5 class="project-modal-title">{{ $project->title }} - <span
                            class="project-modal-project">{{ $project->architect }}</span>
                    </h5>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-2 col-2 text-right">
                    <button class="project-modal-close-btn" onclick="closeModal()">
                        <img class="lazy-load" data-src="{{ asset('/img/x.svg') }}" alt="">
                    </button>
                </div>
            </div>
        </div>

        <div class="project-modal-body">

            <div class="owl-carousel owl-theme">
                @foreach($project->getMedia('media') as $media)
                    <div class="owl-gallery-item">
                        @if(!empty($media))
                            <img class="lazy-load" data-src="{{ $media->getUrl('view') }}" alt="">
                        @else
                            <img class="lazy-load" data-src="{{ asset('/img/placeholder.png') }}" alt="">
                        @endif
                    </div>
                @endforeach
            </div>

        </div>

    </div>
@endif
