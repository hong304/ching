@extends('master')
@section('title', 'Simple and Delicious Chinese Cooking Recipes | Ching He Huang')
@section('fb-ref-image', config('app.url') . '/images/recipes/browse-recipe.jpg')
@section('page-description')
@if($keyword)
Browse all {{$keyword}} recipes from Ching He Huang's collection of delicious Asian fusion dishes.@else
Discover Chinese fusion recipes packed with delicious, fresh and vibrant flavours from TV chef and cookery writer Ching He Huang. Start chopping, get wokking!@endif
@endsection
@section('content')


    <section class="offset-top bg-color white">
        <div class="container-fluid p0">
            <div class="row no-gutters">
                <div class="col">
                    <div class="full-image-holder smaller" style="background-image: url('{{ asset('/images/recipes/browse-recipe.jpg') }}');">
                        <div class="image-text-overlay">
                            <h1 class="text-overlay-title">Browse Recipes</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="bg-color almost-white">
        <div class="pt40 pb40">
            <div class="row m0">
                <div class="col text-center">
                    <div class="col-lg-6 col-12 offset-lg-3 same-padding-with-single-card">
                        <form id="search-recipe" action="{{route('redirectRecipe')}}" method="post">
                            {{csrf_field()}}
                            <div class="courses-selection-holder">
                                <select id="course-selection" class="form-control course-selection select2-box" name="course">
                                    <option value="all">ALL COURSES</option>
                                    @foreach($courseList as $c)
                                        <option value="{{$c->slug}}" {{ $course == $c->slug ? 'selected' : '' }} >{{strtoupper($c->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="search-widget">
                                <label>
                                    <input class="search-field" type="search" name="keyword" id="keyword" placeholder="Search for ingredients" value="{{$keyword}}">
                                    <button type="submit" class="search-button text-uppercase"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </label>
                            </div>
                        </form>
                    </div>
                    {{--<div class="col-12">
                        <a href="/recipe"><button class="filter-button @if((!isset($course)))active @endif" role="button" aria-pressed="true">Show all</button></a>
                        @foreach($courseList as $c)
                            <a href="/recipe/{{$c->id}}"><button class="filter-button @if(isset($course) && $c->id == $course)active @endif" role="button" aria-pressed="true">{{ ucfirst($c->name) }}</button></a>
                        @endforeach
                    </div>--}}
                </div>
            </div>

            <div class="card-group pt40">
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
                                </div>
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
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="hidden-sm-down">
                {{ $recipes->appends($_GET)->links('vendor.pagination.default') }}
            </div>

            <div class="hidden-md-up">
                {{ $recipes->links('vendor.pagination.default-mobile') }}
            </div>


        </div>
    </section>

@endsection


@section('footer-script')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">

        $( function() {

            var availableTags;

//            $.ajax({
//                url : 'ajax',
//                dataType: "json",
//                data: {
//                    type: 'country'
//                },
//                success: function( data ) {
//                    availableTags = data;
//                }
//            });

            availableTags = <?php echo json_encode($lists); ?>

            function split( val ) {
                return val.split( / \s*/ );
            };

            function extractLast( term ) {
                return split( term ).pop();
            }

            $( "#keyword" )
            // don't navigate away from the field on tab when selecting an item
                .on( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                            $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 0,
                    source: function( request, response ) {
                        // delegate back to autocomplete, but extract the last term
                        if(extractLast(request.term).length > 2)
                            var results = $.ui.autocomplete.filter( availableTags, extractLast( request.term ) );
                        if (results && results.length > 6 ){
                            response(results.slice(0, 6));
                        }else {
                            response(results);
                        }
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        var terms = split( this.value );
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push( ui.item.value );
                        // add placeholder to get the comma-and-space at the end
                        terms.push( "" );
                        this.value = terms.join( " " );
                        return false;
                    }
                });
        } );

        $('#course-selection').select2({minimumResultsForSearch: -1});
        $('.select2').css('width', '100%');

        $("select").on('select2:open', function(){
            $('.select2-dropdown').hide().slideDown();
        }).on('select2:close', function(){
            $('.select2-dropdown').show().slideUp();
            $('#keyword').val('');
            $('#search-recipe').submit();
        });

    </script>
@endsection