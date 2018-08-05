@extends('admin.recipe.recipe-form')
@section('recipe-step')

    @php
        $stepValue = $step3;
    @endphp

    <!-- recipe step -->
    <input name="step" type="hidden" value="3">
    <input name="recipe_id" type="hidden" value="{{ $stepValue['recipe_id'] }}">

    <!-- Ingredient section -->
    <div class="section-wrapper" id="section-wrapper">
        <label>Section</label>
        @foreach($stepValue['recipe_section'] as $key=>$recipeIngredientSection)
            <div class="section-box">
                <input type="hidden" class="section_order" value="1" name="section_order[]">
                <button class="section-delete-btn" onclick="removeSection(this)" type="button"><i
                            class="fa fa-times"></i></button>
                <select class="form-control select2-box recipe_section" onchange="onSectionChange(this)">
                    @foreach($ingredientSections as $ingredientSectionItem)
                        <option value="{{ $ingredientSectionItem->id }}" {{ ($key == $ingredientSectionItem->id ? "selected": "") }}>{{ $ingredientSectionItem->name }}</option>
                    @endforeach
                </select>
                <div class="ingredients-div">
                    @for($i = 0; $i< count($recipeIngredientSection); $i++)
                        <div class="two-tabs ingredient-block">
                            <div class="card-block input-holder ingredient-select">
                                <select class="form-control ingredients"
                                        name="recipe_section[{{$key}}][{{$i}}][recipe_ingredient_id]"
                                        data-placeholder="Please select an ingredient">
                                    <option></option>
                                    @foreach($ingredients as $type)
                                        <optgroup label="{{ucfirst($type->name)}}">
                                            @foreach($type->recipeIngredients as $ingredient)
                                                <option value="{{$ingredient->id}}" {{ ($recipeIngredientSection[$i]['recipe_ingredient_id'] == $ingredient->id ? "selected": "") }}>{{ucfirst($ingredient->name)}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <label class="circle-label" for="">{{$i + 1}}</label>
                            </div>
                            <div class="card-block input-holder ingredient-unit">
                                <input type="text" name='recipe_section[{{$key}}][{{$i}}][unit]' class="form-control"
                                       value="{{$recipeIngredientSection[$i]['unit']}}">
                                <label for="">Unit</label>
                            </div>
                            <button class="ingredient-delete-btn" onclick="removeIngredient(this)" type="button"><i
                                        class="fa fa-times"></i></button>
                            <div class="clear-float"></div>
                        </div>
                    @endfor
                </div>
                <button type="button" class="btn btn-next btn-main add-ingredients-btn" onclick="addIngredient(this)">
                    <i class="fa fa-plus" aria-hidden="true"></i> add more items
                </button>
            </div>
        @endforeach

    </div>
    <div class="card-block">
        <button id="add-section-btn" type="button" class="btn btn-next btn-main">
            <i class="fa fa-plus" aria-hidden="true"></i> add more sections
        </button>
    </div>


    <div class="card-block">
        <a class="btn btn-next btn-grey pull-left"
           href="@if(Route::currentRouteName() == "adminRecipes.edit"){{route('adminRecipes.edit', ['id'=>$stepValue['recipe_id'], 'step'=>"step2"])}}@else{{route('adminRecipes.create', 'step2')}}@endif">
            <i class="fa fa-angle-left" aria-hidden="true"></i> Previous
        </a>
        <button id="submit-btn" type="submit" class="btn btn-next btn-main pull-right">
            <i class="fa fa-angle-right" aria-hidden="true"></i> Submit
        </button>
    </div>
@endsection


@section('step-script')
    <script src="{{ elixir('js/sortable.js') }}"></script>
    <!-- step script -->
    <script type="text/javascript" id="133333">
        $(document).ready(function () {
            $('.select2-box').select2();
            $('.ingredients').select2();

            $("#add-section-btn").click(function () {
                $('.select2-box').select2("destroy");
                $('.ingredients').select2("destroy");
                var newSection = $(".section-wrapper >div").last().clone();
                newSection.find('.recipe_section').val('1');
                newSection.find('.section_order').val('1');
                newSection.find('.ingredients-div').find('input').val("");
                newSection.find('.ingredients-div').find('select').val("");
                newSection.find('.ingredients-div').children().slice(3).remove();
                $(".section-wrapper").append(newSection);

                reOrderIngredients($(".section-wrapper >div").last().find('.ingredients-div'), 1);
                $('.select2-box').select2();
                $('.ingredients').select2();
            });

            var element = document.getElementById("section-wrapper"),
                sort = Sortable.create(element, {
                    draggable: ".section-box"
                });

        });

        function onSectionChange(el) {
            $(el).parent().find('.section_order').val($(el).val());
            reOrderIngredients($(el).parent().find('.ingredients-div'), $(el).val());
        }

        function removeSection(el) {
            if ($('.section-box').length > 1) {
                $(el).parent().remove();
            } else {
                alert('Recipe should have at least one section!');
            }
        }

        function addIngredient(el) {
            $('.ingredients').select2("destroy");
            var newIngred = $(el).parent().find('.ingredients-div').children().last().clone();
            newIngred.find('input').val("");
            newIngred.find('select').val("");
            var newIngredNum = newIngred.find('.ingredient-select label').text();
            newIngredNum = parseInt(newIngredNum) + 1;
            newIngred.find('.ingredient-select label').text(newIngredNum);
            $(el).parent().find('.ingredients-div').append(newIngred);
            reOrderIngredients($(el).parent().find('.ingredients-div'), $(el).parent().find('.recipe_section').val());
            $('.ingredients').select2();
        }

        function reOrderIngredients(ingredientsDiv, recipeSection) {
            ingredientsDiv.find('.ingredient-block').each(function (i) {
                $(this).find('.circle-label').text(i + 1);
                $(this).find('input').attr('name', "recipe_section[" + recipeSection + "][" + i + "][unit]");
                $(this).find('select').attr('name', "recipe_section[" + recipeSection + "][" + i + "][recipe_ingredient_id]");
            });
        }

        function removeIngredient(el) {
            var ingredientsDiv = $(el).parent().parent();
            var recipeSection = ingredientsDiv.parent().find('.recipe_section').val();
            if (ingredientsDiv.find('.ingredient-block').length > 1) {
                $(el).parent().remove();
                reOrderIngredients(ingredientsDiv, recipeSection)
            } else {
                alert('Each section should have at least one ingredient!');
            }
        }
    </script>

@endsection