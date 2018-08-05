@extends('master')
@section('title', 'Ching He Huang Chinese Cooking | Video | ' . e($category->name) . ' | ChingHeHuang.com')
@section('page-description', 'Welcome to Ching He Huang\'s ' . e($category->name) . ' — easy-to-follow recipe videos designed to help you cook your favourite Chinese and Asian fusion recipes!') {{-- Defaults --}}
@section('fb-ref-image', $random_lists->first()->image->url())
@section('header-script')
    @if($trailer)
        <link rel="stylesheet" href="/plugins/videojs-airplay/videojs.airplay.css">
        <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "VideoObject",
                "name": "{{$trailer->name}}",
                "description": "@if($trailer->description){{$trailer->description}}@else{{$trailer->name ." | " . $trailer->category->name}}@endif",
                "thumbnailUrl": "{{$trailer->image->url(false,'video')}}",
                "uploadDate": "{{$trailer->created_at}}",
                "duration": "{{$trailer->iso8601_duration($trailer->duration_seconds)}}",
                "publisher": {
                    "@type": "Organization",
                    "name": "Ching He Huang",
                    "logo": {
                        "@type": "ImageObject",
                        "url": "{{ asset('/images/ching-logo-dark.jpg') }}",
                        "width": 252,
                        "height": 60
                    }
                },
                "contentUrl": "{{$trailer->url(false, 'http')}}"
            }
        </script>
    @endif
@endsection

@section('content')

    <!-- feature banner of LKK -->
    <section class="offset-top bg-color almost-white">
        <div class="row no-gutters">
            <div class="col">
                <div class="feature-series-banner">

                    <!-- Tab box -->
                    <div class="series-tab-box">
                        <div class="tab-content">

                            <!-- the intro tab -->
                            <div role="tabpanel" class="tab-content-holder tab-pane fade in active" id="intro">
                                <h3 class="tab-series-title">{{ $category->name }}</h3>
                                <p class="tab-series-intro">{{ $category->description }}</p>
                            </div>

                        </div>
                        <div class="tab-image-overlay"></div>
                        <div class="tab-background-holder">
                            @if($trailer)
                                <div class="trailer-holder">
                                    <video id="video" class="video-js video-size vjs-default-skin vjs-big-play-centered" x-webkit-airplay="allow"
                                           controls preload="metadata"
                                           poster="{{$trailer->image->url()}}">
                                        <source src="{{$trailer->url(false, 'hls')}}" type="application/x-mpegURL"/>
                                        <source src="{{$trailer->url(false, 'http')}}" type="video/mp4"/>
                                        {{--<source src="https://d2zihajmogu5jn.cloudfront.net/bipbop-advanced/bipbop_16x9_variant.m3u8" type="application/x-mpegURL"/>--}}
                                    </video>
                                </div>
                            @else
                                <div class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner" role="listbox">
                                        @foreach( $random_lists as $key => $random )
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <img class="d-block" src="{{ $random->image ? $random->image->url(false,'medium') : asset('/images/video.jpg') }}" alt="{{ $random->name }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <!-- latest video list -->
    <section class="bg-color almost-white">
        <div class="pt40 pb40">

            <div class="video-series-list">

                @foreach( $videoLists as $video )
                    <!-- card -->
                    <div class="card no-border video-thumbnail-holder @if(count($video->users()->pluck('user_id')) >0 && Auth::check()) watched @elseif(!$video->active) coming-soon @endif">
                        @if($category->id == 1 || $category->id == 6)
                            <a @if($video->active) href="{{ route('recipe',$video->recipe->getSlug()) }}" @endif>
                        @else
                             <a href="{{ route('video',['series' => $video->category->getSlug(), 'slug'=>$video->getSlug()]) }}">
                        @endif
                            @if(count($video->users()->pluck('user_id')) >0 && Auth::check())<div class="watched-overlay"><div class="watched-label">Watched</div></div>@endif
                             @if(!$video->active)
                                 <div class="coming-soon-overlay">
                                     <div class="coming-soon-label">
                                         <div class="label-title">Coming soon</div>
                                         <p class="small mb-0">available on {!! \Carbon\Carbon::createFromFormat('Y-m-d', $video->release_date, 'Europe/London')->format('l, j<\\s\\u\\p>S</\\s\\u\\p> F Y') !!}</p>
                                     </div>
                                 </div>
                             @endif
                                <div class="card-img-top card-img-top-250">
                                <div class="card-img-holder">
                                    <div class="video-play-btn"><i class="fa fa-play-circle-o"></i></div>
                                    <img class="img-fluid" src="{{ $video->image ? $video->image->url(false,'medium') : asset('/images/video.jpg') }}" alt="{{ $video->name }}">
                                </div>
                            </div>
                             @if($category->id != 6)
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
                             @endif
                        </a>
                    </div>
                @endforeach
            </div><!-- end of .video-list -->

            <div class="hidden-sm-down">
                {{ $videoLists->links('vendor.pagination.default') }}
            </div>

            <div class="hidden-md-up">
                {{ $videoLists->links('vendor.pagination.default-mobile') }}

            </div>

        </div>
    </section>


@endsection

@section('footer-script')

    <script type="text/javascript">
    $(document).ready(function() {
      setTimeout(function() {
        var videoListCard = $('.card-img-holder');
        var videoListHeight = videoListCard.eq(0).width() / 16 * 9;
        videoListCard.height(videoListHeight);
      },500);
    });
    </script>

    @if($trailer)
        <script src="{{ elixir('js/video.js') }}"></script>
        <script src="/plugins/videojs-airplay/videojs.airplay.js" type="text/javascript"></script>
        {{--<script src="/plugins/videojs-switcher/main.js" type="text/javascript"></script>--}}
        <script type="application/javascript">

        var guest = @if(Auth()->guest()) true @else false @endif;
        var videoPlayed = false;
        $(document).ready(function(){
          checkCount();
          initVideoPlayer();

            $("#video-player").click(function () {
              if (!videoPlayed &&!guest){
                var slug = window.location.pathname.split("/");
                slug = slug[slug.length - 1];
                slug = slug.split("#");
                slug = slug[0];
                console.log('slug');
                $.getJSON( "/video-watched/" + slug, function( data ) {
                  console.log(data);
                });
              }
              videoPlayed = true;
            });

        });

        function initVideoPlayer(){
          var player = videojs('video', {
            preload: "auto",
            controlBar: {
              audioTrackButton: false
            },
            plugins: { airplayButton: {} },
            hls: { overrideNative: true },
            html5: {
              nativeAudioTracks: false,
              nativeVideoTracks: false
            }
          }).ready(function() {
            //console.log('VideoJS started');
          });
        }
        function reInitVideoPlayer(poster, src){
          videojs(document.getElementById('video')).dispose();
          var ios = "";
          if  (iOS()){
            ios = 'x-webkit-airplay="allow"';
          }
          var player = '<video id="video" class="video-js video-size vjs-default-skin vjs-big-play-centered" poster="'+ poster+'" '+ ios +' controls><source src="' + src + '" type="application/x-mpegURL"/></video>';
          $("#video-player").html(player);
          initVideoPlayer();
        }

        function changeVideo(slug, el) {
          //reset video watced
          videoPlayed = false;
          //Update video player
          var poster = $(el).find('.video-img').attr('src');
          var src = $(el).find('.video-url').val();
          reInitVideoPlayer(poster, src);

          //Update url
          $("#video-title").text($(el).find('.list-intro-title').text());
          var url = '/videos/' + slug;
          var url = '/videos/' + slug;
          history.pushState(null, null, url );
          $("#redirect_url").val(window.location.href);
          //change count
          checkCount();
        }
        function checkCount(){
          $.getJSON( "/video-count", function( data ,status) {
            count = parseInt(data.count);
    //                if (count>4 && guest){
            if (guest){
              $('#ask-for-register').show();
            }
          });
        }
        function iOS() {
          var iDevices = [
            'iPad',
            'iPhone',
            'iPod',
          ];
          if (!!navigator.platform) {
            while (iDevices.length) {
              if (navigator.platform === iDevices.pop()){
                return true;
              }
            }
          }
          if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0){
            return true;
          }
          return false;
        }

        </script>
    @endif

@endsection
