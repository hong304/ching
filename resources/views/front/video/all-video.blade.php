@extends('master')
@section('title', 'Ching He Huang Chinese Cooking | Videos | ChingHeHuang.com')
@section('fb-ref-image', config('app.url') . '/images/video/all-video.jpg')
@section('header-script')
@endsection

@section('content')

    <section class="offset-top bg-color white mb40">
        <div class="container-fluid p0">
            <div class="row no-gutters">
                <div class="col">
                    <div class="full-image-holder smaller" style="background-image: url('{{ asset('/images/video/all-video.jpg') }}');">
                        <div class="image-text-overlay">
                            <h1 class="text-overlay-title">Videos</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- click and cook video series -->
    @foreach($data as $d)
    <section class="bg-color white">
        <div>
            <div class="row m0 standard-padding">
                <div class="col-lg-12 text-left">
                    <h2 class="title-text"><a href="{{ route('video-series', $d['slug']) }}">{{$d['name']}}</a></h2>
                    <p class="small-90 mb0">{{ $d['description'] }}</p>
                </div>
            </div>
            <div class="video-list">
                <div class="owl-carousel owl-theme card-group">

                @foreach( $d['videoList'] as $video)
                    <!-- card -->

                        <div class="card no-border video-thumbnail-holder mb0 @if(count($video->users()->pluck('user_id')) >0 &&Auth::check()) watched @elseif(!$video->active) coming-soon @endif">

                            @if($video->video_category_id == 1 || $video->video_category_id == 6)
                                <a @if($video->active) href="{{ route('recipe',$video->recipe->getSlug()) }}" @endif>
                            @else
                                <a href="{{ route('video',['series' => $video->category->getSlug(), 'slug'=>$video->getSlug()]) }}">
                            @endif

                            @if(count($video->users()->pluck('user_id')) >0 && Auth::check())<div class="watched-overlay"><div class="watched-label">Watched</div></div>@endif
                                @if(!$video->active)
                                    <div class="coming-soon-overlay">
                                        <div class="coming-soon-label">
                                            <div class="label-title">Coming soon</div>
                                            <p class="small mb-0">available on {{ $video->release_date }}</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="card-img-top card-img-top-250">
                                    <div class="card-img-holder">
                                        <div class="video-play-btn"><i class="fa fa-play-circle-o"></i></div>
                                        <img class="img-fluid" src="{{ $video->image ? $video->image->url(false,'medium') : asset('/images/video.jpg') }}" alt="{{ $video->name }}">
                                    </div>
                                </div>
                                <div class="card-block p-t-2 text-left video-text-holder">
                                    <h5 class="card-title">{{ $video->name }}</h5>
                                    <div class="video-info-box">
                                        <ul>
                                            <!-- duration of video -->
                                            <li>
                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                @if($video->duration_seconds >=3600)
                                                    {{ gmdate('H:i:s', $video->duration_seconds) }}
                                                @else
                                                    {{ gmdate('i:s', $video->duration_seconds) }}
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
        </div>
    </section>
    @endforeach
@endsection


@section('footer-script')
    <script type="text/javascript">

        $(document).ready(function() {
            $('.carousel').carousel();
            callOwlCarousel();
            $(window).on('load', function() {
                setTimeout(function() {
                    initHeightOfVideoCard();
                }, 100);
            })
        });

        $(window).resize(function() {
            setTimeout(function() {
                initHeightOfVideoCard();
            }, 200);
        })

    </script>
@endsection