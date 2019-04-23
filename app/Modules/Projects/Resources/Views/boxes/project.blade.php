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
            <div id="projectCarousel_{{ $project->slug }}" class="carousel slide" data-ride="carousel">

                <ol class="carousel-indicators">
                    @foreach($project->getMedia('media') as $thumb)
                        <li data-target="#projectCarousel_{{ $project->slug }}"
                            data-slide-to="{{ $loop->index }}"
                            class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                </ol>

                <div class="carousel-inner">
                    @foreach($project->getMedia('media') as $media)
                        <div class="carousel-item @if($loop->first) active @endif">
                            @if(!empty($media))
                                <img class="lazy-load" data-src="{{ $media->getUrl() }}" alt="">
                            @else
                                <img class="lazy-load" data-src="https://via.placeholder.com/300C/O https://placeholder.com/" alt="">
                            @endif
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#projectCarousel_{{ $project->slug }}" role="button"
                   data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#projectCarousel_{{ $project->slug }}" role="button"
                   data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>

            </div>
        </div>

    </div>
@endif
