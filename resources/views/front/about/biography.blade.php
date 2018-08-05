@extends('master')

@section('title', 'Ching He Huang Chinese Cooking | Biography | ChingHeHuang.com')
@section('page-description', 'Ching He Huang is an International Emmy nominated TV chef & cookery author who has become an ambassador of Chinese cooking around the world. Find out more here!')
@section('fb-ref-image', config('app.url') . '/images/about/tn-ching-he-huang.jpg')
@section('header-script')

@endsection



@section('content')

    {{--<section class="offset-top bg-color white">--}}
        {{--<div class="container-fluid p0">--}}
            {{--<div class="row no-gutters">--}}
                {{--<div class="col">--}}
                    {{--<div class="full-image-holder bio-header" style="background-image: url('{{ asset('/images/about/tn-ching-he-huang.jpg') }}');"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}

    <section class="offset-top bg-color white mt-xs-0">
        <div class="container mb40">
            <div class="row m0 pt40">
                <div class="col-lg-8 col-md-8 col-12 p0-xs">
                    <div class="text-left">
                        <div class="static-page-content">
                            <h1 class="static-content-title">About Ching</h1>
                            <div class="full-image-holder bio-header" style="background-image: url('{{ asset('/images/about/tn-ching-he-huang.jpg') }}');"></div>
                            <p class="static-content-text mt16">Ching is an International Emmy nominated TV chef &
                                cookery author who has become an ambassador of Chinese cooking around the world.
                                Born in Taiwan, raised in South Africa and U.K., cookery was a vital connection
                                between Ching and her Chinese heritage.</p>
                            <p class="static-content-text">Ching's approach to cookery stems from the traditional
                                cooking and lifestyles of her farming community grandparents in Southern Taiwan, and
                                these are her major food influences.</p>
                            <img class="img-big img-wrap-text-right" src="{{ asset('/images/about/ching.jpg') }}" alt="Ching He Huang's Lotus Wok Set"/>
                            <p class="static-content-text">Her creative food ethos is to use fresh, organic and
                                ethically sourced ingredients to create modern dishes with Chinese heritage, fusing
                                tradition and innovation. Ching strives to bridge cultural understanding through
                                food, making Chinese cooking accessible, healthy and nutritious, appealing to both
                                the East and West.</p>
                            <p class="static-content-text">Ching has demonstrated she is the go-to expert for
                                Chinese cuisine. Her career in the media as a TV chef and author has spanned the
                                last decade, transforming people's perceptions of Chinese food over this time by
                                keeping it fresh, popular and engaged. She works tirelessly to promote Chinese
                                cuisine through her TV shows, books, wok range and involvement in many high profile
                                campaigns and causes.</p>
                            <p class="static-content-text">Ching's dynamic approach to modern Chinese food is
                                evident in her immensely popular TV work. Many of her shows are sold, distributed
                                and broadcast around the world. Her own fronted series in the UK include -
                                <strong><i>Ching's Kitchen (30' X 15) (Good Food Channel)</i></strong>,
                                <strong><i>Chinese Food Made Easy (30' X 6)(BBC2)</i></strong>,
                                <strong><i>Chinese Food in Minutes (30' X 10) (C5)</i></strong>,
                                <strong><i>Exploring China (60' X 4) (BBC2)</i></strong>,
                                <strong><i>The Big Eat (30' X 10) (Food Network)</i></strong> and <strong><i>Ching's Amazing Asia (30' X 10)</i></strong> (Food Network).
                                Ching has also hosted two episodes of <strong><i>Saturday Kitchen Live BBC1 (90' X 1)</i></strong>.</p>
                            <p class="static-content-text">Subsequently she has enjoyed huge success in the U.S.
                                commissioned by the Cooking Channel with Easy Chinese: San Francisco (30' X 13),
                                Easy Chinese: New York & L.A. (30' X 13) (for which she received a Daytime Emmy
                                Award Nomination) and Easy Chinese: New Year Special (60' X 1). More recently she
                                presented two series of Restaurant Redemption (30' X 13) and Eat the Nation (60' X
                                1). Her U.S. appearances include The Today Show (NBC), Rachael Ray Show (CBS), Iron
                                Chef America (Food Network) (both as a contestant and judge).</p>
                            <img class="img-medium img-wrap-text-left" src="{{ asset('/images/about/eat-clean-book.jpg') }}" alt="Eat Clean - Wok Yourself to Health by Ching He Huang"/>
                            <p class="static-content-text">Ching is a regular guest TV chef in the U.K. including
                                Saturday Kitchen (BBC1), Food and Drink (BBC2) , Munch Box (ITV1), Sunday Brunch
                                (C4), Weekend Kitchen (C4), Lorraine (ITV1) as well as a series on Waitrose TV.</p>
                            <p class="static-content-text">Ching has published seven best-selling cookbooks to date
                                including Eat Clean: Wok Yourself to Health, Exploring China, Ching's Fast Food,
                                Everyday Easy Chinese, Ching's Chinese Food in Minutes, Chinese Food Made Easy and
                                China Modern.</p>
                            <p class="static-content-text">Ching is the creator & founder of The Lotus Wok – a wok with a dynamic nano-silica coating for high performance cooking.</p>
                            <div class="clear-float"></div>
                        </div><!-- end of .static-page-content -->

                        <div class="mt40 mb40 p0"><div class="title-divider"></div></div>

                        <div class="row offer-section">

                            <div class="col-sm-6 col-12">
                                <!-- offer box -->
                                <div class="offer-box">
                                    <div class="offer-wrapper">
                                        <img class="img-half img-wrap-text-left" src="{{ asset('/images/about/eat-clean-book.jpg') }}" alt="Eat Clean - Wok Yourself to Health by Ching He Huang"/>
                                        <div class="offer-intro">
                                            <h5>Eat Clean: Wok Yourself to Health</h5>
                                            <p>A REVOLUTIONARY EAST-WEST APPROACH TO EATING WELL Eat Clean and feel great with over 100 nutritious and easy Asian soups, salads and stir-fries for everyday health.</p>
                                            {!! str_replace('button-in-light', 'button-in-dark call-for-action text-uppercase small-90', \App\Models\RecipeSource::find(9)->getLink(true)) !!}
                                            {{--<div class="call-for-action text-uppercase small-90">Buy</div>--}}
                                        </div>
                                        <div class="clear-float"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-12">
                                <!-- offer box -->
                                <a href="http://www.asianfoodchannel.com/shows/chings-amazing-asia" target="_blank">
                                    <div class="offer-box">
                                        <img class="full-height" src="{{ asset('/images/offer/AmazingAsia_PreTitles_Still.jpg') }}" alt="Amazing Asia" />
                                    </div>
                                </a>
                            </div>

                        </div><!-- end of .offer-section -->

                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12 p0-xs">
                    @include('front.widget.side-tvshow-panel')
                </div>

            </div><!-- end of .row -->
        </div>
    </section>


@endsection




@section('footer-script')
<script type="text/javascript">

    $(document).ready(function() {
        setWrapBoxHeight();
        $('.offer-box').eq(1).height($('.offer-box').eq(0).height());
    });

    window.onresize = function() {
        setTimeout(function() {
            setWrapBoxHeight();
            $('.offer-box').eq(1).height($('.offer-box').eq(0).height());
        }, 300);
    };

</script>
@endsection