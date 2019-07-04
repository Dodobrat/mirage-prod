@if(!empty($workflow))

    <div class="custom-container-content">
        <div class="full-screen-btn-container">
            <button class="full-screen-btn"
                    id="workflow-modal">
                <i class="ti-fullscreen"></i>
            </button>
        </div>
        <div class="owl-carousel owl-theme owl-workflow">

            @foreach($workflow->getMedia('comic') as $media)
                <div class="owl-workflow-item">
                    @if(!empty($media))
                        <img class="workflow-load" data-src="{{ $media->getUrl('view') }}" alt="">
                    @else
                        <img class="workflow-load" data-src="{{ asset('/img/placeholder.png') }}" alt="">
                    @endif
                </div>
            @endforeach

        </div>
    </div>

    <div class="workflow-modal-container">
        <div class="workflow-modal-content">
            <button class="close-workflow-modal">
                <i class="ti-close"></i>
            </button>
            <div class="owl-carousel owl-theme owl-modal-workflow">

                @foreach($workflow->getMedia('comic') as $media)
                    <div class="owl-modal-workflow-item">
                        @if(!empty($media))
                            <img class="modal-workflow-load" data-src="{{ $media->getUrl('view') }}" alt="">
                        @else
                            <img class="modal-workflow-load" data-src="{{ asset('/img/placeholder.png') }}" alt="">
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
    </div>

@endif
