<div class="row no-gutters standard-padding">
    <div class="col-lg-12 text-center mt40">
        <h2 class="title-text">Watch Ching</h2>
        <p class="text-uppercase mb8">Food, Travel & Fun</p>
    </div>
    <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-10 offset-1 mb40"><div class="title-divider"></div></div>
</div>


<div class="video-list mb40">
    <div class="owl-carousel owl-theme card-group">
    @foreach( $latestVideoList as $latestVideo)
        <!-- card -->
            <div class="card no-border video-thumbnail-holder mb0">
                <a href="{{ route('video',['series'=>$latestVideo->category->getSlug(), 'slug'=>$latestVideo->getSlug()]) }}">
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
                                    @if($latestVideo->duration_seconds >=3600)
                                        {{ gmdate('H:i:s', $latestVideo->duration_seconds) }}
                                    @else
                                        {{ gmdate('i:s', $latestVideo->duration_seconds) }}
                                    @endif
                                </li>
                            </ul>
                        </div><!-- end of .video-info-box -->
                    </div>
                </a>
            </div>
        @endforeach

    </div><!-- end of .owl-carousel -->
</div><!-- end of .video-list -->