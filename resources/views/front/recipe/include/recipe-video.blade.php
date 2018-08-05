<div class="collapse-video-player-holder">
    <video id="video" class="video-js video-size vjs-default-skin vjs-big-play-centered" x-webkit-airplay="allow"
           {{-- data-setup='{ "controls": true, "autoplay": false, "preload": "none" }' --}}
           controls preload="auto" poster="{{ $recipe->video->image->url(false,'video') }}">
        <source src="{{ $recipe->video->url(false,'hls') }}" type="application/x-mpegURL" />
        <source src="{{ $recipe->video->url(false,'http') }}" type="video/mp4" />
    </video>
</div>