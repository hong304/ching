@extends('master')
@section('title', e($video->name) . '| '. e($video->category->name) .' | Ching He Huang')
@section('page-description', $video->description)
@section('fb-ref-image', $video->image->url())
@section('header-script')
    <link rel="stylesheet" href="/plugins/videojs-airplay/videojs.airplay.css">
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "VideoObject",
            "name": "{{$video->name}}",
            "description": "@if($video->description){{$video->description}}@else{{$video->name ." | " . $video->category->name}}@endif",
            "thumbnailUrl": "{{$video->image->url(false,'video')}}",
            "uploadDate": "{{$video->created_at}}",
            "duration": "{{$video->iso8601_duration($video->duration_seconds)}}",
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
            "contentUrl": "{{$video->url(false, 'http')}}"
        }
    </script>
@endsection

@section('content')


    <!-- the rolling step script -->
    <section class="bg-color white offset-top" >
        <div class="container-fluid p0">
            <div class="row m0 bg-color main standard-padding">
                <div class="col">
                    <h1 class="video-title" id="video-title">{{ $video->name }}</h1>
                </div>
            </div>
            <div class="row m0 video-player-holder">
                <div class="indi-video-holder" id="video-player">
                    <video id="video" class="video-js video-size vjs-default-skin vjs-big-play-centered" x-webkit-airplay="allow"
                           controls preload="metadata"
                           poster="{{$video->image->url()}}">
                        <source src="{{$video->url(false, 'hls')}}" type="application/x-mpegURL"/>
                        <source src="{{$video->url(false, 'http')}}" type="video/mp4"/>
                        {{--<source src="https://d2zihajmogu5jn.cloudfront.net/bipbop-advanced/bipbop_16x9_variant.m3u8" type="application/x-mpegURL"/>--}}
                    </video>
                </div>

                <div class="side-series-video-list">
                    <ul class="side-rolling-list-holder">


                        <!-- each video item inside the rolling list -->
                        @foreach($videoSeriesList as $v)
                        <a href="javascript:void(0);" class="video-link" onclick="changeVideo('{{$v->category->getSlug()."/".$v->slug}}', this)">
                            <li class="list-holder">
                                <div class="list-img-holder">
                                    <input type="hidden" class="video-url" value="{{$v->url(false, 'hls', false)}}">
                                    <div class="video-play-btn"><i class="fa fa-play-circle-o"></i></div>
                                    <span class="list-intro-duration">
                                        @if($v->duration_seconds >=3600)
                                            {{ gmdate('H:i:s', $v->duration_seconds) }}
                                        @else
                                            {{ gmdate('i:s', $v->duration_seconds) }}
                                        @endif
                                    </span>
                                    <img class="img-fluid video-img" src="{{$v->image->url(false,'small')}}" alt="{{$v->name}}">
                                </div>
                                <div class="list-intro-holder">
                                    <h5 class="list-intro-title">{{$v->name}}</h5>
                                    <p class="list-intro-text">{{$v->description}}</p>
                                </div>
                                <div class="clear-float"></div>
                            </li>
                        </a>
                        @endforeach

                    </ul>
                </div>

            </div>
        </div>
    </section>

    {{--@if (app()->environment() == 'production')--}}
        @include('master.message.ask-for-register')
    {{--@endif--}}

@endsection

@section('footer-script')

    <script src="{{ elixir('js/video.js') }}"></script>
    <script src="/plugins/videojs-airplay/videojs.airplay.js" type="text/javascript"></script>
    {{--<script src="/plugins/videojs-switcher/main.js" type="text/javascript"></script>--}}
    <script type="application/javascript">

        var guest = @if(Auth()->guest()) true @else false @endif;
        var videoPlayed = false;
        $(document).ready(function(){
            checkCount();
            initVideoPlayer();

            {{--$("#go-to-login").click(function() {--}}
                {{--ga('send', 'event', 'Popup', 'Login', 'Popup');--}}
                {{--var link = window.location.href;--}}
                {{--localStorage.setItem('link', link );--}}
                {{--window.location.href = "{{route('index', '#login')}}";--}}
            {{--});--}}

            {{--$("#go-to-register").click(function () {--}}
                {{--ga('send', 'event', 'Popup', 'Registration', 'Popup');--}}
                {{--window.location.href = "{{route('index', '#register')}}";--}}
            {{--});--}}

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

@endsection