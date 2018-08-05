@extends('master')
@section('title', e($recipe->name) . " Recipe | Ching He Huang")
@section('url', "recipes/" . $slug)
@section('page-description', str_limit($recipe->intro,150))
@section('fb-ref-image', $recipe->video ? $recipe->video->image->url() : $recipe->image->url())
@section('header-script')
    <link rel="stylesheet" href="/plugins/videojs-airplay/videojs.airplay.css">
    <script type="application/ld+json">
    {
        "@context": "http://schema.org/",
        "@type": "Recipe",
        "name": "{{$recipe->name}}",
        "image": "{{($recipe->image ? $recipe->image->url() : '')}}",
        "author": {
            "@type": "Person",
            "name": "Ching He Huang"
        },
        "datePublished": "{{$recipe->created_at}}",
        "description": "{{trim($recipe->intro)}}",
        "prepTime": "PT{{$recipe->preparation_time}}M",
        "totalTime": "PT{{$recipe->cooking_time + $recipe->preparation_time}}M",
        "nutrition": {
            "@type": "NutritionInformation",
            "servingSize": "per serving",
            "calories": "{{$recipe->nutrition->cals}} cal",
            "carbohydrateContent": "{{$recipe->nutrition->carbs}} g",
            "proteinContent": "{{$recipe->nutrition->protein}} g",
            "fatContent": "{{$recipe->nutrition->fat}} g"
        },
        "recipeIngredient": [@for($j = 0; $j<count($ingredients); $j++)
            @for($i = 0; $i<count($ingredients[$j]['ingredients']); $i++)
                "{{trim($ingredients[$j]['ingredients'][$i]['unit']) ." ". ucfirst(trim($ingredients[$j]['ingredients'][$i]['name'])) }}
                "@if(!($i == count($ingredients[$j]['ingredients'])-1 && $j == count($ingredients) -1)),@endif
            @endfor
        @endfor],
        "recipeInstructions": "@foreach($recipe->steps as $step) {{$step->instruction}} @endforeach",
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "{{ round(rand(30,50)/10,1) }}",
            "reviewCount": "{{ round(time() / 10000000,0) }}"
        }
    }

    </script>
    @if($recipe->video)
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "VideoObject",
            "name": "{{$recipe->video->name}}",
            "description": "@if($recipe->video->description){{$recipe->video->description}}@else{{$recipe->video->name ." | " . $recipe->video->category->name}}@endif",
            "thumbnailUrl": "{{$recipe->video->image->url(false,'video')}}",
            "uploadDate": "{{$recipe->video->created_at}}",
            "duration": "{{$recipe->video->iso8601_duration($recipe->video->duration_seconds)}}",
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
            "contentUrl": "{{$recipe->video->url(false, 'http')}}"
        }

        </script>
    @endif
@endsection
@section('content')

    <!-- pinterest pin -->
    <meta property="og:site_name" content="{{config('app.url')}}" />
    <div itemscope itemtype="http://schema.org/Recipe" class="pinterest-pin-hidden">
        <h1 itemprop="name">{{$recipe->name}}</h1>
        <meta itemprop="url" content="{{ config('app.url').'/recipes/'.$slug }}" />
        <span itemprop="recipeYield">
            @if ($recipe->makes)
                Makes : {{$recipe->makes}}
            @elseif($recipe->serves_main && $recipe->serves_shared)
                Serves : {{$recipe->serves_main}} - {{$recipe->serves_shared}}
            @elseif ($recipe->serves_main)
                Serves : {{$recipe->serves_main}}
            @elseif ($recipe->serves_shared)
                Serves : {{$recipe->serves_shared}}
            @endif
        </span>
        <span itemprop="prepTime">Preparation {{ intval(date('H', mktime(0, $recipe->preparation_time))) * 60 + intval(date('i', mktime(0, $recipe->preparation_time))) }} mins</span>
        <span itemprop="cookTime">Cooking {{ intval(date('H', mktime(0, $recipe->cooking_time))) * 60 + intval(date('i', mktime(0, $recipe->cooking_time))) }} mins</span>
        <span itemprop="totalTime">Total {{ intval(date('H', mktime(0, $recipe->preparation_time))) * 60 + intval(date('i', mktime(0, $recipe->preparation_time))) + intval(date('H', mktime(0, $recipe->cooking_time))) * 60 + intval(date('i', mktime(0, $recipe->cooking_time))) }}</span>

        <div itemprop=”nutrition” itemscope itemtype=”http://schema.org/NutritionInformation”>
            Nutrition facts:
            <span itemprop=”calories”>{{$recipe->nutrition->cals}} calories</span>
            <span itemprop=”proteinContent”>{{$recipe->nutrition->protein}}g protein</span>
            <span itemprop=”carbohydrateContent”>{{$recipe->nutrition->carbs}}g carbs</span>
            <span itemprop=”sugarContent”>{{$recipe->nutrition->sugars}}g sugars</span>
            <span itemprop=”fatContent”>{{$recipe->nutrition->fat}}g fat</span>
            <span itemprop=”saturatedFatContent”>{{$recipe->nutrition->satfat}}g </span>
            <span itemprop=”fiberContent”>{{$recipe->nutrition->fibre}}g fibre</span>
            <span itemprop=”sodiumContent”>{{$recipe->nutrition->sodium}}mg sodium</span>
        </div>

        @foreach($ingredients as $in)

            {{$in['section']}}:
            @for($i = 0; $i<count($in['ingredients']); $i++)
                <span itemprop="{{ strtolower($in['section']) }}">{{$in['ingredients'][$i]['unit']}} {{ ucfirst($in['ingredients'][$i]['name']) }}</span>
            @endfor

        @endforeach

        <span itemprop="description">{!! $recipe->intro_content !!}</span>

        @foreach($random_related_recipe as $v)
            <a href="{{route('recipe',[$v->getSlug()])}}" itemprop="relatedItem"></a>
        @endforeach
    </div>
    <!-- end of pinterest pin -->



    <!-- the video holder -->
    <section class="offset-top bg-color main">
        <div class="container-fluid">
            <div class="row standard-padding">
                <div class="col-12 recipe-title">
                    <h1 class="recipe-name text-color white">{{$recipe->name}}</h1>
                    <!-- <a data-toggle="modal" data-target="#videoModal"><i class="fa fa-video-camera" aria-hidden="true"></i></a> -->
                    <ol class="recipe-caption text-color white">
                        <li class="start-caption">
                            @if ($recipe->makes)
                                Makes : {{$recipe->makes}}
                            @elseif($recipe->serves_main && $recipe->serves_shared)
                                Serves : {{$recipe->serves_main}} - {{$recipe->serves_shared}}
                            @elseif ($recipe->serves_main)
                                Serves : {{$recipe->serves_main}}
                            @elseif ($recipe->serves_shared)
                                Serves : {{$recipe->serves_shared}}
                            @endif
                        </li>
                        <li class="between-caption">
                            Preparation time
                            @if (intval(date('H', mktime(0, $recipe->preparation_time))) > '0')
                                {{ intval(date('H', mktime(0, $recipe->preparation_time))) }} Hours
                            @endif
                            @if (intval(date('i', mktime(0, $recipe->preparation_time))) > '0')
                                {{ intval(date('i', mktime(0, $recipe->preparation_time))) }} Minutes
                            @endif
                        </li>
                        <li class="end-caption">
                            Cooking time
                            @if (intval(date('H', mktime(0, $recipe->cooking_time))) > '0')
                                {{ intval(date('H', mktime(0, $recipe->cooking_time))) }} Hours
                            @endif
                            @if (intval(date('i', mktime(0, $recipe->cooking_time))) > '0')
                                {{ intval(date('i', mktime(0, $recipe->cooking_time))) }} Minutes
                            @endif
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>


    <section class="pt40 pb40">
        <div class="row m0 standard-padding">
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mb16">
                <div class="recipe-details">
                    <div class="thumbnailHolder">
                        <div class="imageRenderBox" style="background-image: url({{ $recipe->image ? $recipe->image->url(false,'large') : '' }})"></div>
                        {{--<img @if($recipe->video) id="imgHeight" @else class="img-fluid"--}}
                        {{--@endif src="{{ $recipe->image ? $recipe->image->url(false,'large') : '' }}"/>--}}
                    </div>
                    <h5 class="text-uppercase mb16">per serving</h5>
                    <div class="row no-gutters m0 mb8">
                        <span class="col nutrition-box" id="start-box"><p>Cals</p><hr><p>{{$recipe->nutrition->cals}}</p></span>
                        <span class="col nutrition-box" id="start-box"><p>Protein (g)</p><hr><p>{{$recipe->nutrition->protein}}</p></span>
                        <span class="col nutrition-box" id="start-box"><p>Carbs (g)</p><hr><p>{{$recipe->nutrition->carbs}}</p></span>
                        <span class="col nutrition-box" id="end-box"><p>Sugars (g)</p><hr><p>{{$recipe->nutrition->sugars}}</p></span>
                    </div>
                    <div class="row no-gutters m0">
                        <span class="col nutrition-box" id="start-box"><p>Fat (g)</p><hr><p>{{$recipe->nutrition->fat}}</p></span>
                        <span class="col nutrition-box" id="start-box"><p>Sat Fat (g)</p><hr><p>{{$recipe->nutrition->satfat}}</p></span>
                        <span class="col nutrition-box" id="start-box"><p>Fibre (g)</p><hr><p>{{$recipe->nutrition->fibre}}</p></span>
                        <span class="col nutrition-box" id="end-box"><p>Sodium (mg)</p><hr><p>{{$recipe->nutrition->sodium}}</p></span>
                    </div>
                    <div class="mt40 mb40 p0">
                        <div class="title-divider"></div>
                    </div>
                    <div class="row">
                        <div class="col tags-section">
                            <i class="fa fa-tag text-color main" aria-hidden="true"></i>
                            @foreach($recipe->tags as $tag)
                                <a class="ml8 mr8"
                                   href="{{route('recipe-search',['all',$tag->name])}}">{{$tag->name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt40 mb40 p0">
                        <div class="title-divider"></div>
                    </div>

                    @if($recipe->source)
                        <h5 class="text-uppercase mb16">Source from</h5>
                        <p class="small-90">{!! $recipe->source->getLink() !!}</p>
                        <div class="mt40 mb40 p0">
                            <div class="title-divider"></div>
                        </div>
                    @endif

                <!-- will put to the end on mobile -->
                    <div class="hidden-sm-down">
                        <h5 class="text-uppercase mb16">share this recipe</h5>
                        <div class="row mb16 no-gutters share-button-area">
                            <div class="col-lg-6 col-md-12 col-6">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}"
                                   target="_blank" class="btn btn-block btn-fb text-uppercase social-btn"><i
                                            class="fa fa-facebook"></i> Facebook</a>
                            </div>
                            <div class="col-lg-6 col-md-12 col-6">
                                <a href="https://plus.google.com/share?url={{ urlencode(Request::url()) }}"
                                   target="_blank" class="btn btn-block btn-google text-uppercase social-btn"><i
                                            class="fa fa-google-plus"></i> Google</a>
                            </div>
                            <div class="col-lg-6 col-md-12 col-6">
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{rawurlencode("'".$recipe->name."' via @ChingHeHuang")}}"
                                   target="_blank" class="btn btn-block btn-twitter text-uppercase social-btn"><i
                                            class="fa fa-twitter"></i> Twitter</a>
                            </div>
                            <div class="col-lg-6 col-md-12 col-6">
                                <a href="https://pinterest.com/pin/create/button/?{{http_build_query(['url' => Request::url(), 'media' => ($recipe->image ? $recipe->image->url() : ''), 'description' => $recipe->intro ])}}"
                                   target="_blank" class="btn btn-block btn-pinterest text-uppercase social-btn"><i
                                            class="fa fa-pinterest"></i> Pinterest</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12 col-12">
                @if($recipe->video)
                    @include('front.recipe.include.recipe-video')
                @endif
                <h3 class="text-uppercase section-title">About the recipe </h3>
                <a href="{{route('recipe-search',['course'=>$recipe->recipe_course->slug])}}"
                   class="categories-tag text-uppercase">
                    <div class="inner-text">{{$recipe->recipe_course->name}}</div>
                </a>
                <a class="print-btn" href="{{ route('recipe-print', [$recipe->getSlug()]) }}"><i class="fa fa-print"
                                                                                                 aria-hidden="true"></i></a>
                <div class="clear-float"></div>
                <p class="section-intro">
                    {!! $recipe->intro_content !!}
                </p>

                <!-- the collapse ingredient -->
                <div class="hidden-xl-up mb16 mt16">
                    <a id="collapse-vertical-arrow" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseIngredients" aria-expanded="false" aria-controls="collapseIngredients">
                        <div class="collapse-title text-left">
                            <span>Ingredients</span> <i class="fa fa-plus-circle" aria-hidden="true"></i><i
                                    class="fa fa-minus-circle" aria-hidden="true"></i>
                        </div>
                    </a>
                    <div id="collapseIngredients" class="collapse" role="tabpanel" aria-labelledby="caption">
                        @include('front.recipe.include.ingredient-card')
                    </div>
                </div>
                <!-- end of the collapse ingredient -->

                <div class="mt40 mb40 p0">
                    <div class="title-divider"></div>
                </div>
                <h4 class="text-uppercase">Steps</h4>
                <ul class="steps-list">
                    @foreach($recipe->steps as $step)
                        <li>{{$step->instruction}}</li>
                    @endforeach
                </ul>
                <div class="mt40 mb40 p0">
                    <div class="title-divider"></div>
                </div>

                <!-- will put to the end on mobile -->
                <div class="hidden-md-up">
                    <h5 class="text-uppercase mb16">share this recipe</h5>
                    <div class="row mb16 no-gutters share-button-area">
                        <div class="col-lg-6 col-md-12 col-6">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}"
                               target="_blank" class="btn btn-block btn-fb text-uppercase social-btn"><i
                                        class="fa fa-facebook"></i> Facebook</a>
                        </div>
                        <div class="col-lg-6 col-md-12 col-6">
                            <a href="https://plus.google.com/share?url={{ urlencode(Request::url()) }}" target="_blank"
                               class="btn btn-block btn-google text-uppercase social-btn"><i
                                        class="fa fa-google-plus"></i> Google</a>
                        </div>
                        <div class="col-lg-6 col-md-12 col-6">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{rawurlencode("'".$recipe->name."' via @ChingHeHuang")}}"
                               target="_blank" class="btn btn-block btn-twitter text-uppercase social-btn"><i
                                        class="fa fa-twitter"></i> Twitter</a>
                        </div>
                        <div class="col-lg-6 col-md-12 col-6">
                            <a href="https://pinterest.com/pin/create/button/?{{http_build_query(['url' => Request::url(), 'media' => ($recipe->image ? $recipe->image->url() : ''), 'description' => $recipe->intro ])}}"
                               target="_blank" class="btn btn-block btn-pinterest text-uppercase social-btn"><i
                                        class="fa fa-pinterest"></i> Pinterest</a>
                        </div>
                    </div>
                    <div class="mt40 mb40 p0">
                        <div class="title-divider"></div>
                    </div>
                </div>

                <div class="row related-recipe">

                    <div class="col-12">
                        <h5 class="text-uppercase mb16">YOU MIGHT ALSO LIKE...</h5>
                    </div>

                    @foreach($random_related_recipe as $v)
                    <!-- a column for each related recipe -->
                        <div class="col">
                            <div class="card no-border">
                                <a href="{{route('recipe',[$v->getSlug()])}}" itemprop="relatedItem">
                                    <div class="related-recipe-card">
                                        <div class="card-img-top">
                                            <div class="card-img-holder">
                                                <img class="img-fluid"
                                                     src="{{ $v->image ? $v->image->url(false,'small') : '' }}"
                                                     alt="{{$v->name}}">
                                            </div>
                                        </div>
                                        <div class="card-block text-left">
                                            <h5 class="card-title">{{$v->name}}</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="col-xl-3 col-lg-8 offset-xl-0 offset-lg-2 hidden-lg-down">
                @include('front.recipe.include.ingredient-card')
            </div>
        </div>
    </section>


    {{--@if (app()->environment() == 'production')--}}
    @include('master.message.ask-for-register')
    {{--@endif--}}



@endsection


@section('footer-script')


    <script src="{{ elixir('js/video.js') }}"></script>
    {{--<script src="/plugins/videojs-switcher/main.js" type="text/javascript"></-script>--}}
    <script src="/plugins/videojs-airplay/videojs.airplay.js" type="text/javascript"></script>
    <script type="text/javascript">

        var guest = @if(Auth()->guest()) true
        @else false @endif;
        $(document).ready(function () {
            checkCount();
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
        });

        function checkCount() {
            $.getJSON("/video-count", function (data, status) {
                count = parseInt(data.count);
//                if (count>4 && guest){
                if (guest) {
                    $('#ask-for-register').show();
                }
            });
        }

                @if($recipe->video)

        var player = videojs('video', {
                preload: "auto",
                controlBar: {
                    audioTrackButton: false
                },
                plugins: {airplayButton: {}},
                hls: {overrideNative: true},
                html5: {
                    nativeAudioTracks: false,
                    nativeVideoTracks: false
                }
            }, function () {

                $(document).ready(function () {
                    // fired after video js init
                    setTimeout(function () {
                        if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                            $('.thumbnailHolder').height($('.video-size').height());
                            console.log('Resize vid and thumb')
                        }
                    }, 300);
                });

                $(window).resize(function () {
                    if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                        $('.thumbnailHolder').height($('.video-size').height());
                        console.log('Resize vid and thumb')
                    }
                });

            });
        @endif

        $(document).on('input', 'textarea', function () {
            var minRows = this.getAttribute('data-min-rows') | 0,
                rows;
            this.rows = minRows;
            this.baseScrollHeight = this.baseScrollHeight | calcBaseScrollHeight(this);
            rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 25);
            this.rows = minRows + rows;
            console.log(rows);
        });

        function calcBaseScrollHeight(textArea) {
            var savedValue = textArea.value,
                baseScrollHeight;
            textArea.value = '';
            baseScrollHeight = textArea.scrollHeight;
            textArea.value = savedValue;
            return baseScrollHeight;
        }


    </script>
    <script>
        //social btn popup
        var popupSize = {
            width: 780,
            height: 550
        };

        $(document).on('click', '.social-btn', function (e) {

            var verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
                horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

            var popup = window.open($(this).prop('href'), 'social',
                'width=' + popupSize.width + ',height=' + popupSize.height +
                ',left=' + verticalPos + ',top=' + horisontalPos +
                ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

            if (popup) {
                popup.focus();
                e.preventDefault();
            }

        });
    </script>

    <script type="text/javascript">
        // print the ingredients card function

        $('.print-btn').click(function (e) {
            var recipePrint = window.open($(this).prop('href'), '', 'left=60,top=30,width=700,height=930,toolbar=0,scrollbars=0,status=0');

            if (recipePrint) {
                recipePrint.focus();
                e.preventDefault();
            }
        });

    </script>

@endsection