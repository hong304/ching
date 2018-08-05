@extends('print')
@section('title', 'Print Recipe')
@section('header-script')

@endsection
@section('content')



    <section class="pt40 pb40">
        <div class="row m0 standard-padding">
            <div class="col-4 mb16">
                <div class="recipe-details">
                    <div class="thumbnailHolder">
                        <img class="img-fluid" src="{{ $recipe->image ? $recipe->image->url() : '' }}" />
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="recipe-title mb40">
                    <h1 class="recipe-name text-color main pt0">{{$recipe->name}}</h1><!-- <a data-toggle="modal" data-target="#videoModal"><i class="fa fa-video-camera" aria-hidden="true"></i></a> -->
                    <ol class="recipe-caption text-color main">
                        <li class="start-caption border-color main">
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
                        <li class="between-caption border-color main">
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

                <div class="recipe-details">
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
                </div>
            </div>
            <div class="col-12 mt24">
                <h3 class="text-uppercase section-title">About the recipe </h3>
                <div class="categories-tag text-uppercase">
                    <div class="inner-text">{{$recipe->recipe_course->name}}</div>
                </div>
                <p class="section-intro">
                    <?PHP
                    if(strpos($recipe->intro,'*Serves')>0)
                        echo substr($recipe->intro,0,strpos($recipe->intro,'*Serves'));
                    elseif(strpos($recipe->intro,'Serves')>0)
                        echo substr($recipe->intro,0,strpos($recipe->intro,'Serves'));
                    else
                        echo $recipe->intro;

                    ?></p>
                <hr>
                <h4 class="text-uppercase">Steps</h4>
                <ul class="steps-list">
                    @foreach($recipe->steps as $step)
                        <li>{{$step->instruction}}</li>
                    @endforeach
                </ul>
            </div>


        </div>

        <div class="row m0 standard-padding mt40">
            <!-- Ingredient card -->
            @foreach($ingredients as $in)
                <div class="col-6">
                    <div class="card card-block p-t-2 text-left no-border ingredients-card bg-color almost-white printIngredients" id="printIngredients">
                        <h5 class="card-title text-color main">{{$in['section']}}</h5>
                        <ul class="card-text ingredients-list">

                            @for($i = 0; $i<count($in['ingredients']); $i++)
                                <li>
                                    <strong>{{ ucfirst($in['ingredients'][$i]['name']) }}</strong>
                                    <span class="ingredients-name">{{$in['ingredients'][$i]['unit']}}</span>
                                </li>
                            @endfor

                        </ul>
                    </div>
                </div>
            @endforeach
        </div>

    </section>




@endsection


@section('footer-script')


@endsection