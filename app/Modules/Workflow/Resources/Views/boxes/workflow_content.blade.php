@if(!empty($workflow))

    <div class="container my-5 py-5">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header text-center">{{ $workflow->title }}</div>
                    <div class="card-body">
                        <h5 class="card-title">Under Construction!</h5>
                        <p class="card-text">Sorry for the inconvenience</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif
