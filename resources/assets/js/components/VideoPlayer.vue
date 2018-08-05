<template>
    <div class="container-fluid p0">
        <div class="row m0 bg-color main standard-padding">
            <div class="col">
                <h1 class="video-title">{{ video.name }}</h1>
            </div>
        </div>
        <div class="row m0 video-player-holder">
            <div class="indi-video-holder" v-html="videoPlayer">

            </div>

            <div class="side-series-video-list">
                <ul class="side-rolling-list-holder">


                    <!-- each video item inside the rolling list -->
                    <router-link :to="v.link" v-for="v in videoList" @click.native="changeVideo(v)">
                        <li class="list-holder">
                            <div class="list-img-holder">
                                <div class="video-play-btn"><i class="fa fa-play-circle-o"></i></div>
                                <span class="list-intro-duration">3:06</span>
                                <img class="img-fluid" :src="v.poster" :alt="v.name">
                            </div>
                            <div class="list-intro-holder">
                                <h5 class="list-intro-title">{{v.name}}</h5>
                                <p class="list-intro-text">{{v.description}}</p>
                            </div>
                            <div class="clear-float"></div>
                        </li>
                    </router-link>


                </ul>
            </div>

        </div>
    </div>
</template>
<script>

     export default{
        mounted() {
            this.fetchVideos();
        },
        data(){
            return{
                slug: this.$route.params.slug,
                nextPageUrl: "/video-data/" + this.$route.params.slug,
                video: [],
                videoList:[],
                nextPage: 1,
                videoPlayer : "",
                videoJsPlayer: ""
            }
        },
        methods:{
            fetchVideos:function(){
                var ios = "&ios=";
                if(this.iOS()){
                    ios = ios + "true";
                }else{
                    ios = ios + "false";
                }
                return this.$http.get(this.nextPageUrl + "?page=" + this.nextPage + ios)
                    .then((resp)=>{
                        this.video = resp.body.video;
                        this.videoList = resp.body.videoList.data;
                        this.nextPage = resp.body.videoList.currentPage + 1;
                        this.videoPlayer = this.getVideoPlayer(this.video.poster, this.video.src);
                        return true;
                    }).then((resp)=>{
                        this.initPlayer();
                    }).catch(function (err) {
                        console.log('REJECTED!');
                    }).bind(this);
            },
            changeVideo: function(video){
                videojs('video').dispose();
                this.slug = video.slug;
                this.video = video;
                this.videoPlayer = this.getVideoPlayer(video.poster, video.src);
                this.$nextTick().then(function(){
                    setTimeout(function(){
                        videojs('video' ,{ "controls": true, "autoplay": true, "preload": "auto"} );
                    }, 10);
                });
            },
            getVideoPlayer: function(poster, src){
                var ios = "";
                if(this.iOS()){
                    ios = 'x-webkit-airplay="allow"';
                }
                var player = '<video id="video" class="video-js video-size vjs-default-skin vjs-big-play-centered" poster="'+ poster+'" '+ ios +' controls preload="auto" autoplay><source src="' + src + '" type="video/mp4"/></video>';
                return player;
            },
            initPlayer: function(){
                videojs('video' ,{ "controls": true, "autoplay": true, "preload": "auto"} );
            }
            ,iOS : function () {
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
        }
    }

</script>
