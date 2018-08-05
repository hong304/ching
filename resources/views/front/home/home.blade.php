@extends('master')
@section('title', 'Ching He Huang | TV Chef, Author & Chinese Cuisine Expert')
@section('fb-ref-image', config('app.url') . '/images/carousel/see-ching-in-action.jpg')
@section('header-script')

@endsection



@section('content')


    <!-- the big carousel section -->
    <section class="offset-top">
        <h1 style="display:none;">Ching He Huang Official Website - Chinese Cooking Recipes</h1>
        @include('front.home.include.carousel')
    </section>


    <!-- most popular section -->
    <section class="bg-color white pt40 pb40">
        @include('front.home.include.most-popular')
    </section>


    <!-- the amazing asia tv show offer banner -->
    <section class="bg-color black">
        <div class="offer-image-holder">
            <div class="bg-image" style="background-image: url('{{ asset('/images/offer/LKK.jpg') }}')"></div>
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-sm-6 col-12 text-sm-right text-center mt40 mb40 mb-xs-0">
                        <div class="v-align-middle">
                            <h3 class="title-text text-color white">New Series: FLAVOLOGY</h3>
                            <p class="small-90 text-color white mb24">Ching travels to Hong Kong in search of seriously tasty dishes and shows you how ro recreate some of those magical flavours in your own kitchen using Chinese sauce specialists Lee Kum Kee.</p>
                            <a href="{{ route('video-series', 'flavology') }}" class="button-in-dark text-uppercase">watch here</a>
                        </div>
                    </div>
                    <div class="col-sm-4 offset-sm-1 col-12 mt40 mb40">
                        <div class="img-full-width text-center">
                            <img src="{{ asset('/images/offer/LKK_Flavology.jpg') }}" class="img-fluid" alt="Ching-He Huang's Flavology by Lee Kum Kee" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- the feature section -->
    <section class="bg-color white pt40 pb40">
        @include('front.home.include.browse-recipes')
    </section>


    <!-- the eat clean offer banner -->
    <section class="bg-color" style="background-color: #518ec8;">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-sm-2 col-8 offset-sm-3 offset-2 mt40 mb40 mb-xs-0">
                    <div class="img-full-width text-center">
                        <img src="{{ asset('/images/about/eat-clean-book.jpg') }}" class="img-fluid shadow" alt="Eat Clean - Wok Yourself to Health by Ching-He Huang" />
                    </div><!-- end of .big-video-holder -->
                </div>
                <div class="col-sm-6 offset-sm-1 col-12 text-sm-left text-center mt40 mb40">
                    <div class="v-align-middle">
                        <h3 class="title-text text-color white">Eat Clean - Wok Yourself to Health</h3>
                        <p class="text-color white small-90 mb24">Eat Clean and feel great with over 100 nutritious and easy Asian soups, salads and stir-fries for everyday health.</p>
                        {{--<a href="https://www.amazon.co.uk/Eat-Clean-Wok-Yourself-Health/dp/0007426291/ref=sr_1_4?ie=UTF8&qid=1489384851&sr=8-4&keywords=ching+he+huang" target="_blank" class="button-in-dark text-uppercase">buy now</a>--}}
                        {{--<a href="{{ route('books.shop', 'eat-clean-wok-yourself-to-health') }}" target="_blank" class="button-in-dark text-uppercase">buy now</a>--}}
                        {!! str_replace('button-in-light', 'button-in-dark', \App\Models\RecipeSource::find(9)->getLink(true)) !!}
                        <a href="{{ route('books') }}" target="_blank" class="button-in-dark text-uppercase ml8">See more</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- the instagram section -->
    {{--<section class="bg-color white pt40 pb40">--}}
        {{--@include('front.home.include.instagram')--}}
    {{--</section>--}}

    <!-- the inspiration section -->
    <section class="bg-color white pt40 pb40">
        @include('front.home.include.watch-ching')
    </section>




    @if (session('status') == 'success')
        <div class="screen-overlay">
            <div class="popup-box successful-popup">
                <div class="label-check-icon"><i class="fa fa-check"></i></div>
                <div class="message-title">@if (session('message_title')) {{ session('message_title') }} @else {{ session('status') }} @endif</div>
                <p class="message-content small-90">{!! session('message') !!}</p>
                <button class="btn btn-main popup-close-btn">Close</button>
            </div>
        </div>

        @elseif(session('status') == 'fail' && session('from') != 'forgotpassword')

        <div class="screen-overlay">
            <div class="popup-box failure-popup">
                <div class="label-check-icon"><i class="fa fa-times"></i></div>
                <div class="message-title">@if (session('message_title')) {{ session('message_title') }} @else {{ session('status') }} @endif</div>
                <p class="message-content small-90">{!! session('message') !!}</p>
                <button class="btn btn-error popup-close-btn">Close</button>
            </div>
        </div>
    @endif



@endsection


@section('footer-script')
    <script type="text/javascript">
        var headerType = $('.big-slider-img').attr('data-toggle');
        $('.ga-button').on('click', function eventTrackClick(e) {
          e.preventDefault();
          var target = this;
          var headerNum = $(target).attr('data-toggle');
          ga('send',{
            hitType : 'event',
            eventCategory : 'Front Page ' + headerType,
            eventAction : 'Header Button Click',
            eventLabel : 'Header Content' + headerNum,
            hitCallback : function(){
              $(target).off('click', eventTrackClick);
              target.click();
            }
          });
        })
    </script>
    <script type="text/javascript">

        $(document).ready(function () {

            $('#myCarousel').carousel({
                interval:   4000
            });

            callOwlCarousel();
            initHeightOfVideoCard();
            if (localStorage.getItem('link')){
                $("#redirect_url").val(localStorage.getItem('link'));
                localStorage.clear();
            }
            @if (session('status') == 'success'&& session('from') == 'register')
                 ga('send', 'event', 'Popup', 'Registration', 'Registration Success');
            @endif
        });

        var clickEvent = false;
        $('#myCarousel').on('click', '.nav li', function() {
            clickEvent = true;
            $('.nav li').removeClass('active');
            $(this).addClass('active');
        }).on('slid.bs.carousel', function(e) {
            if(!clickEvent) {
                var count = $('.nav').children().length -1;
                var current = $('.nav li.active');
                current.removeClass('active').next().addClass('active');
                var id = parseInt(current.data('slide-to'));
                if(count == id) {
                    $('.nav li').first().addClass('active');
                }
            }
            clickEvent = false;
        });

        $('.screen-overlay').click(function() {
            $(this).fadeOut("slow");
        });

        $('.popup-close-btn').click(function() {
            $('.screen-overlay').fadeOut("slow");
        });


        // init the video card height again when user resize the window
        $(window).resize(function() {
            setTimeout(function() {
                initHeightOfVideoCard();
            }, 300);
        })

    </script>
@endsection