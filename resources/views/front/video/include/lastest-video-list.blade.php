<div class="row m0 standard-padding">
    <div class="col-lg-12 text-left mt40">
        <h2 class="title-text">Latest Video</h2>
    </div>
</div>
<div class="video-list">
    <div class="owl-carousel owl-theme card-group">

        @foreach( $latestVideoList as $latestVideo)
            <!-- card -->
            <div class="card no-border video-thumbnail-holder mb0 watched">
                <a href="{{ route('video', ['series'=>$latestVideo->category->getSlug(), 'slug'=>$latestVideo->getSlug()]) }}">

                    <!-- if user watched this video, this label will show -->
                    <div class="watched-overlay"><div class="watched-label">Watched</div></div>
                    <!-- end of label, if user watched this video, this label will show -->

                    <div class="card-img-top card-img-top-250">
                        <div class="card-img-holder">
                            <div class="video-play-btn"><i class="fa fa-play-circle-o"></i></div>
                            <img class="img-fluid" src="{{ $latestVideo->image ? $latestVideo->image->url(false,'medium') : asset('/images/video.jpg') }}" alt="{{ $latestVideo->name }}">
                        </div>
                    </div>
                    <div class="card-block p-t-2 text-left video-text-holder">
                        <h5 class="card-title">{{ $latestVideo->name }}</h5>
                        <div class="video-info-box">
                            <ul>
                                <!-- duration of video -->
                                <li>
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    {{ intval(date('i:s', mktime(0, $latestVideo->duration_seconds))) }}
                                </li>
                            </ul>
                        </div><!-- end of .video-info-box -->
                    </div>
                </a>
            </div>
        @endforeach

    </div><!-- end of .owl-carousel -->
</div><!-- end of .video-list -->