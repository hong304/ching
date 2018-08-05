<!-- Ingredient card -->
@foreach($ingredients as $in)
<div class="card card-block p-t-2 text-left no-border ingredients-card bg-color almost-white printIngredients" id="printIngredients">
    <h5 class="card-title text-color main">{{$in['section']}}</h5>
    <ul class="card-text ingredients-list">

        @for($i = 0; $i<count($in['ingredients']); $i++)
        <li>
            <strong>{{ ucfirst($in['ingredients'][$i]['name']) }}</strong> -
            <span class="ingredients-name">{{$in['ingredients'][$i]['unit']}}</span>
        </li>
        @endfor

    </ul>
</div>
@endforeach