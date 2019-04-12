<div class="project-modal-content">

    <div class="project-modal-header">
        <div class="row align-items-center">
            <div class="col-lg-11 col-md-11 col-sm-10 col-10">
                <h5 class="project-modal-title">Title - <span class="project-modal-project">This is project</span></h5>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-2 col-2 text-right">
                <button class="project-modal-close-btn">
                    <img src="{{ asset('/img/x.svg') }}" alt="">
                </button>
            </div>
        </div>
    </div>

    <div class="project-modal-body">
        <div id="projectCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#projectCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#projectCarousel" data-slide-to="1"></li>
                <li data-target="#projectCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://via.placeholder.com/350" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/450" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/250" alt="...">
                </div>
            </div>
            <a class="carousel-control-prev" href="#projectCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#projectCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

</div>
