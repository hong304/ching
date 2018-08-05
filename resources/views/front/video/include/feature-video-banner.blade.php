<div class="feature-series-banner">

    {{--<div class="series-tab-nav">--}}
        {{--<ul class="nav nav-tabs" role="tablist">--}}
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link active" href="#hotw" role="tab" data-toggle="tab">Hot Of The Wok</a>--}}
            {{--</li>--}}
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link" href="#lkk" role="tab" data-toggle="tab">Lee Kum Kee</a>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</div>--}}

    <!-- Tab box -->
    <div class="series-tab-box">
        <div class="tab-content">

            <!-- the intro tab -->
            <div role="tabpanel" class="tab-content-holder tab-pane fade in active" id="hotw">
                <h3 class="tab-series-title">Hot Off The Wok</h3>
                <p class="tab-series-intro">some series intro some series intro some series intro some series intro some series intro some series intro some series intro some series intro </p>
            </div>

        </div>
        <div class="tab-image-overlay"></div>
        <div class="tab-background-holder">
            <div class="video-play-btn"><a href="{{ route('video-series', 'hot-off-the-wok') }}"><i class="fa fa-play-circle-o"></i></a></div>
            <div class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img class="d-block" src="{{ asset('/images/offer/LKK.jpg') }}" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block" src="{{ asset('/images/video/lkk/feature-1.jpg') }}" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block" src="{{ asset('/images/video/lkk/feature-2.jpg') }}" alt="Third slide">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>