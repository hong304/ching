@extends('admin.recipe.recipe-form')

@section('recipe-step')

    @php
        $stepValue = $step1;
    @endphp

    <!-- recipe step -->
    <input name="step" type="hidden" value="1">
    <input name="recipe_id" type="hidden" value="{{$stepValue['recipe_id']}}">

    <!-- recipe name section -->
    <div class="card-block">
        <label>Recipe Name</label>
        <input type="text" name="recipe_name" class="form-control"
               value="{{ $stepValue['recipe_name'] }}">
    </div>

    <!-- recipe slug section -->
    <div class="card-block">
        <label>Slug (Optional)</label>
        <input type="text" name="slug" class="form-control"
               value="{{ $stepValue['slug'] }}">
    </div>
    <!-- course and serves section -->
    <div class="two-tabs">
        <!-- course -->
        <div class="card-block">
            <label>Recipe Course</label>
            <select class="form-control select2-box" id="recipe_course" name="recipe_course">
                @foreach($recipeCourses as $recipeCourse)
                    <option value="{{ $recipeCourse->id }}" {{ (($stepValue['recipe_course']) == $recipeCourse->id ? "selected": "" )}}>{{ ucfirst($recipeCourse->name) }}</option>
                @endforeach
            </select>
        </div>

        <!-- serves -->
        <div class="card-block">
            <label>Serves</label>
            <div class="clear-float"></div>
            <div class="two-tabs">
                <select class="form-control select2-box" id="recipe_serves" name="recipe_serves">
                    <option value="serves_main" {{ ($stepValue['recipe_serves']) == 'serves_main' ? "selected" : "" }}>
                        Serves
                    </option>
                    <option value="serves_shared" {{ ($stepValue['recipe_serves']) == 'serves_shared' ? "selected" : "" }}>
                        Shared
                    </option>
                    <option value="serves_and_shared" {{ ($stepValue['recipe_serves']) == 'serves_and_shared' ? "selected" : "" }}>
                        Serves and Shared
                    </option>
                    <option value="makes" {{ ($stepValue['recipe_serves']) == 'makes' ? "selected" : "" }}>
                        Makes
                    </option>
                </select>
            </div>
            <div class="two-tabs">
                <input type="text" name="serves_number" class="form-control" id="serves_number"
                       value="{{ $stepValue['serves_number'] }}">
                <input type="text" name="serves_shared_number" class="form-control" id="serves_shared_number"
                       value="{{ $stepValue['serves_shared_number'] }}">
            </div>
        </div>
        <div class="clear-float"></div>
    </div>

    <!-- preparation and cooking time section -->
    <div class="two-tabs">
        <!-- Preparation -->
        <div class="card-block">
            <label>Preparation Time</label>
            <div class="time-section">
                <input type="number" name="preparation_time" class="form-control" id="preparation_time"
                       value="{{ $stepValue['preparation_time'] }}" min="0">
                <span class="clock-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
            </div>
        </div>

        <!-- Cooking -->
        <div class="card-block">
            <label>Cooking Time</label>
            <div class="time-section">
                <input type="number" name="cooking_time" class="form-control" id="cooking_time"
                       value="{{ $stepValue['cooking_time'] }}" min="0">
                <span class="clock-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
            </div>
        </div>
        <div class="clear-float"></div>
    </div>


    <!-- recipe image section -->
    <div class="card-block">
        <label class="pull-left">Recipe Image</label>
        <ul class="nav nav-tabs pull-left" id="imageSelectionTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#uploadImage" role="tab"
                   aria-controls="uploadImage"><i class="fa fa-upload" aria-hidden="true"></i> Upload new image</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#selectFromGallery" role="tab"
                   aria-controls="selectFromGallery"><i class="fa fa-folder-open" aria-hidden="true"></i> Select from
                    gallery</a>
            </li>
        </ul>
        <div class="tab-content clear-float">

            <!-- for user to upload a new image for the recipe
                 and display the preview of the image -->
            <div class="image-preview-holder @if(!isset($stepValue['image_path']))no-image @endif">
                <div class="image-preview-crop">
                    <img class="image-preview" id="image-preview"
                         src="@if(isset($stepValue['image_path'])){{Storage::url($stepValue['image_path'])}}@endif">
                </div>
            </div><!-- end of .image-preview-holder -->

            <div class="tab-pane active" id="uploadImage" role="tabpanel">
                <div class="card-block">
                    <div class="file-box">
                        <input type="hidden" name="image_path" id="image_path"
                               value="@if(isset($stepValue['image_path'])){{$stepValue['image_path']}}@endif"/>
                        <input type="file" name="recipe_image" id="recipe_image" class="input-file-btn" files
                               onchange="changeImageSelected(this)"/>
                        <label for="recipe_image">
                            <strong>
                                <span><i class="fa fa-picture-o" aria-hidden="true"></i> Choose a file</span>
                            </strong>
                        </label>
                    </div>
                </div>
            </div><!-- end of .tab-pane -->

            <div class="tab-pane" id="selectFromGallery" role="tabpanel">
                <input type="hidden" name="recipe_image_id" id="recipe_image_id"
                       value="{{$stepValue['recipe_image_id']}}">
                <div class="card-block">
                    <ul class="nav nav-tabs" role="tablist" id="imageCategoryTab">
                        @foreach($imageCategories as $key=>$imageCategory)
                            <li class="nav-item">
                                <a class="nav-link @if($key == 0) active @endif" data-toggle="tab"
                                   href="#{{$imageCategory}}" role="tab">{{ucfirst($imageCategory)}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-content">
                    @foreach($imageCategories as $key=>$imageCategory)
                        <div class="tab-pane image-tab @if($key == 0) active @endif" id="{{$imageCategory}}"
                             role="tabpanel">
                            <div class="card-deck">
                            </div>
                            <button class="btn btn-main" disabled type="button"
                                    onclick="ajaxLoadImage(this, '{{$imageCategory}}', '2')">More ...
                            </button>
                        </div>
                    @endforeach
                </div>
            </div><!-- end of .tab-pane -->

        </div>
    </div>


    <!-- recipe intro section -->
    <div class="card-block">
        <input type="hidden" name="recipe_intro" id="recipe_intro"
               value="{{$stepValue['recipe_intro']}}">
        <label>Recipe Intoduction</label>
        <textarea id="editor">{{$stepValue['recipe_intro']}}</textarea>
        <p class="small">A 50-200 word introduction to the recipe. Please make the first 100 characters include keywords
            for the dish (it will be used as the meta description for search engine results).</p>
    </div>

    <!-- recipe tags section -->
    <div class="card-block">
        <label>Tags</label>
        <select class="form-control select2-box" id="recipe_tags" multiple="multiple" name="recipe_tags[]">

            @foreach($recipeTags as $recipeTag)
                <option value="{{$recipeTag->id}}" {{ (isset($stepValue['recipe_tags']) && in_array($recipeTag->id, $stepValue['recipe_tags']) ) ? "selected": "" }}>{{ucwords($recipeTag->name)}}</option>
            @endforeach

            @if(isset($stepValue['recipe_tags']))
                @foreach($stepValue['recipe_tags'] as $recipeTag)
                    @if(!is_numeric($recipeTag))
                        <option value="{{$recipeTag}}" selected>{{ucwords($recipeTag)}}</option>
                    @endif
                @endforeach
            @endif

        </select>
    </div>

    <!-- recipe source from section -->
    <div class="card-block">
        <label>Source from</label>
        <select class="form-control select2-box" id="recipe_source" name="recipe_source">
            <option value="0" selected>None</option>
            @foreach($recipeSources as $recipeSource)
                <option value="{{ $recipeSource->id }}" {{ ($stepValue['recipe_source']) == $recipeSource->id ? "selected": "" }}>{{ $recipeSource->name }}</option>
            @endforeach
        </select>
    </div>


    <!-- recipe seo meta tag section -->
    <div class="card-block">
        <label>SEO Meta tags (optional)</label>
        <input type="text" name="recipe_seo_meta" class="form-control"
               value="{{ $stepValue['recipe_seo_meta'] }}">
        <p class="small">If you would like to customise the meta description for this recipe, please write a
            140-character introduction to the recipe.</p>
    </div>
    <div class="card-block row">
        <div class="col-sm-4">
            <div class="card-block">
                <label>Scheduled Date</label>
                <input type="text" class="form-control" name="scheduled_date" placeholder="YYYY-mm-dd"
                       value="{{old('scheduled_date', ($stepValue['publish_at'])? (new DateTime($stepValue['publish_at']))->format('Y-m-d') : '') }}"
                       id="scheduled_date">
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card-block">
                <label>Hour</label>
                <input type="number" class="form-control" name="scheduled_hour"
                       value="{{old('scheduled_hour', ($stepValue['publish_at'])?(new DateTime($stepValue['publish_at']))->format('H'):'')}}"
                       max="23" min="0">
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card-block">
                <label>Minute</label>
                <input type="number" class="form-control" name="scheduled_minute"
                       value="{{old('scheduled_minute', ($stepValue['publish_at'])?(new DateTime($stepValue['publish_at']))->format('i'):'')}}"
                       max="59" min="0">
            </div>
        </div>
    </div>
    <div class="card-block">
        <label>Active</label>
        <select class="form-control select2-box" id="active" name="active">
            <option value="1" {{ $stepValue['active'] == "1" ? "selected": "" }}>Active</option>
            <option value="0" {{ $stepValue['active'] == "0" ? "selected": "" }}>Inactive</option>
        </select>
    </div>

    <div class="card-block">
        <button id="submit-btn" type="submit" class="btn btn-next btn-main pull-right">
            <i class="fa fa-angle-right" aria-hidden="true"></i> Next
        </button>
    </div>
@endsection


@section('step-script')
    <!-- step script -->
    <script src="/plugins/jquery-ui-datepicker/jquery-ui.min.js" type="text/javascript"></script>
    <script src="{{ asset('plugins/imageGallery.js') }}"></script>
    <script type="text/javascript" id="133333">
        var recipe_serve;

        $(document).ready(function () {
            $("#scheduled_date").datepicker({dateFormat: "yy-mm-dd"});

            recipe_serve = $('#recipe_serves');

            var simplemde = new SimpleMDE({element: $("#editor")[0]});

            $("#submit-btn , #save-draft-btn").click(function (e) {
                e.preventDefault();
                $("#recipe_intro").val(simplemde.value());
                $("#create_recipe_form").submit();
            });

            $('.select2-box').select2({minimumResultsForSearch: -1});
            $('#recipe_tags').select2({
                tags: true
            });

            $('.select2').css('width', '100%');

            var api = "{{route('image-data-api')}}";
            initImageGallery($("#recipe_image"), $("#recipe_image_id"), api);

            checkServeType();

            recipe_serve.change(function () {
                checkServeType();
            });
        });

        // serves js
        function checkServeType() {
            if (recipe_serve.val() == "serves_and_shared") {
                $('#serves_number').css({
                    "width": "calc(50% - 0.25rem)",
                    "float": "left",
                    "margin-right": "0.5rem"
                });
                setTimeout(function () {
                    $('#serves_shared_number').show();
                }, 200);
            } else {
                $('#serves_shared_number').hide();
                setTimeout(function () {
                    $('#serves_number').removeAttr("style");
                }, 50);
            }
        }
    </script>

@endsection