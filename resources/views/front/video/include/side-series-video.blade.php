<div class="side-series-video-list">
    <ul class="side-rolling-list-holder">

        @foreach( $videoSeriesList as $videoSeries)
            <!-- each video item inside the rolling list -->
            <a href="{{ route('video', ['series'=>$videoSeries->category->getSlug(), 'slug'=>$videoSeries->getSlug()]) }}">
                <li class="list-holder">
                    <div class="list-img-holder">
                        <div class="video-play-btn"><i class="fa fa-play-circle-o"></i></div>
                        <img class="img-fluid" src="{{ $videoSeries->image ? $videoSeries->image->url(false,'medium') : asset('/images/video.jpg') }}" alt="{{ $videoSeries->name }}">
                    </div>
                    <div class="list-intro-holder">
                        <h5 class="list-intro-title">{{ $videoSeries->name }}</h5>
                        <span class="list-intro-duration">3:06</span>
                        <p class="list-intro-text">{{ $videoSeries->description }}</p>
                    </div>
                    <div class="clear-float"></div>
                </li>
            </a>

        @endforeach

    </ul>
</div>