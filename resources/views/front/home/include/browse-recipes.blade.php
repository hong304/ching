<div class="row no-gutters">
    <div class="col-12 text-center mt40">
        <h2 class="title-text">Browse Recipes</h2>
        <p class="text-uppercase mb8">Get cooking</p>
    </div>
    <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-10 offset-1 mb40">
        <div class="title-divider"></div>
    </div>
</div>
<div class="row no-gutters">
    <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-10 offset-1 mb40 text-center">
        <a href="{{route('recipe')}}" class="btn btn-main text-uppercase">Browse all recipes</a>
    </div>
</div>

    <div class="card-group pt40 standard-padding">

        @foreach($recipes as $recipe)
            <!-- card -->
            <div class="card no-border">
                <?php $video = 0?>
                @if($recipe->video)
                    <?php $video = 1 ?>
                @endif

                <a href="{{ route('recipe',[$recipe->getSlug()]) }}">
                    <div class="recipe-card">
                        <div class="card-img-top">
                            <div class="card-img-holder">
                                @if($recipe->video)
                                    <div class="recipe-video-play-btn"><i class="fa fa-play-circle-o"></i></div>
                                    <img class="recipe-video-thumbnail" src="{{ $recipe->video->image ? $recipe->video->image->url(false,'medium') : ''}}" alt="{{$recipe->name}}">
                                @else
                                    <img class="img-fluid" src="{{ $recipe->image ? $recipe->image->url(false,'medium') : '' }}" alt="{{$recipe->name}}">
                                @endif
                            </div>
                        </div><!-- end of .card-img-top -->
                        <div class="card-block text-left">
                            <h5 class="card-title">{{$recipe->name}}</h5>
                            <div class="cate-label-box">
                                <ul>
                                    <li>
                                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
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

                                    <!-- preparation time -->
                                    <li>
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        Preparation :
                                        @if (intval(date('H', mktime(0, $recipe->preparation_time))) > '0')
                                            {{ intval(date('H', mktime(0, $recipe->preparation_time))) }} Hours
                                        @endif
                                        @if (intval(date('i', mktime(0, $recipe->preparation_time))) > '0')
                                            {{ intval(date('i', mktime(0, $recipe->preparation_time))) }} Minutes
                                        @endif
                                    </li>

                                    <!-- cooking time -->
                                    @if ($recipe->cooking_time != '')
                                        <li>
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            Cooking :
                                            @if (intval(date('H', mktime(0, $recipe->cooking_time))) > '0')
                                                {{ intval(date('H', mktime(0, $recipe->cooking_time))) }} Hours
                                            @endif
                                            @if (intval(date('i', mktime(0, $recipe->cooking_time))) > '0')
                                                {{ intval(date('i', mktime(0, $recipe->cooking_time))) }} Minutes
                                            @endif
                                        </li>
                                    @endif

                                </ul>
                            </div><!-- end of .cate-label-box -->
                        </div>
                    </div><!-- end of .recipe-card -->
                </a>
            </div>
        @endforeach

    </div><!-- end of .card-group -->