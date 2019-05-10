<div class="row align-items-center keep-aspect" data-url="{{ route('projects.getProject') }}">
    @foreach($projects as $project)
        <div class="col-lg-3 col-md-4 col-sm-6 col-6 p-1 gallery-item {{ $project->category->slug }}">

            <div class="gallery-card">
                <button id="modal-btn"
                        onclick="openModal( '{{ $project->id }}','{{ $project->slug }}')"
                        class="project-modal-btn">
                    @if(!empty($project->getMedia('media')) && $project->getMedia('media')->count() > 1)
                        <img src="{{ asset('/img/icon-gallery.png') }}" class="multiple-images" alt="">
                    @endif
                    @if(!empty($project->getFirstMedia('media')))
                        <img src="{{ $project->getFirstMedia('media')->getUrl('thumb') }}"
                             alt="{{ $project->title }}"
                             class="gallery-item-img">
                    @else
                        <img src="{{ asset('/img/placeholder.png') }}"
                             alt="{{ $project->title }}"
                             class="gallery-item-img">
                    @endif
                </button>
                <div class="overlay">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="overlay-title">
                                {{ $project->title }}
                            </h4>
                        </div>
                        <div class="col-12">
                            <p class="overlay-text">
                                {{ $project->architect }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    @endforeach
</div>

<input id="page" type="hidden" value="{{ $projects->currentPage() + 1 }}">
