@extends('admin.recipe.recipe-form')
@section('recipe-step')
    @php
        $stepValue = $step2;
    @endphp
    <!-- recipe step -->
    <input name="step" type="hidden" value="2">
    <input name="recipe_id" type="hidden" value="{{ $stepValue['recipe_id'] }}">

    <!-- Nutrition section -->
    <div class="card-block">
        <label>Nutrition</label>
        <div class="four-tabs">
            <div class="form-group input-holder">
                <input type="number" name="cals" class="form-control" id="cals" step=".01" min="0"
                       value="{{ $stepValue['cals'] }}">
                <label for="cals">Cals</label>
            </div>
            <div class="form-group input-holder">
                <input type="number" name="protein" class="form-control" id="protein" step=".01" min="0"
                       value="{{ $stepValue['protein'] }}">
                <label for="protein">Protein (g)</label>
            </div>
            <div class="form-group input-holder">
                <input type="number" name="carbs" class="form-control" id="carbs" step=".01" min="0"
                       value="{{ $stepValue['carbs'] }}">
                <label for="carbs">Carbs (g)</label>
            </div>
            <div class="form-group input-holder">
                <input type="number" name="sugars" class="form-control" id="sugars" step=".01" min="0"
                       value="{{ $stepValue['sugars'] }}">
                <label for="sugars">Sugars (g)</label>
            </div>
            <div class="form-group input-holder">
                <input type="number" name="fat" class="form-control" id="fat" step=".01" min="0"
                       value="{{ $stepValue['fat'] }}">
                <label for="fat">Fat (g)</label>
            </div>
            <div class="form-group input-holder">
                <input type="number" name="satfat" class="form-control" id="satfat" step=".01" min="0"
                       value="{{ $stepValue['satfat'] }}">
                <label for="satfat">Sat Fat (g)</label>
            </div>
            <div class="form-group input-holder">
                <input type="number" name="fibre" class="form-control" id="fibre" step=".01" min="0"
                       value="{{ $stepValue['fibre'] }}">
                <label for="fibre">Fibre (g)</label>
            </div>
            <div class="form-group input-holder">
                <input type="number" name="sodium" class="form-control" id="sodium" step=".01" min="0"
                       value="{{ $stepValue['sodium'] }}">
                <label for="sodium">Sodium (mg)</label>
            </div>
            <div class="clear-float"></div>
        </div>
    </div>


    <!-- Steps section -->
    <div class="card-block steps-content">
        <label>Steps</label>
        <div id="steps-div">
            @for($i =0; $i< count($stepValue['steps']); $i++ )
                <div class="form-group input-holder">
                    <input type="text" name="steps[]" class="form-control"
                           value="{{ $stepValue['steps'][$i] }}">
                    <label class="circle-label" for="">{{ $i + 1 }}</label>
                    <a class="remove-step" onclick="removeStep(this)"><i class="fa fa-times" aria-hidden="true"></i></a>
                </div>
            @endfor
        </div>
        <button id="add-step-btn" type="button" class="btn btn-next btn-main">
            <i class="fa fa-plus" aria-hidden="true"></i> add more step
        </button>
    </div>


    <div class="card-block">
        <a class="btn btn-next btn-grey pull-left" href="@if(Route::currentRouteName() == "adminRecipes.edit"){{route('adminRecipes.edit', ['id'=>$stepValue['recipe_id'], 'step'=>"step1"])}}@else{{route('adminRecipes.create', 'step1')}}@endif">
            <i class="fa fa-angle-left" aria-hidden="true"></i> Previous
        </a>
        <button id="submit-btn" type="submit" class="btn btn-next btn-main pull-right">
            <i class="fa fa-angle-right" aria-hidden="true"></i> Next
        </button>
    </div>
@endsection


@section('step-script')
    <!-- step script -->
    <script type="text/javascript">
        $(document).ready(function () {
            $("#add-step-btn").click(function () {
                var newStep = $('#steps-div >div').last().clone();

                var nextStepNum = newStep.find('label').text();
                nextStepNum = parseInt(nextStepNum) + 1;
                newStep.find('label').text(nextStepNum);
                newStep.find('input').val("");
                $("#steps-div").append(newStep);
            });
        });
        function removeStep(el) {
            $(el).parent().remove();
            $("#steps-div").children().each(function (i) {
                $(this).find('label').text(i + 1);
            });
        }
    </script>

@endsection