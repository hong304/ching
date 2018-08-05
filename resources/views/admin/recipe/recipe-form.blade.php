@extends('admin')

@section('title', 'Edit Blog')

@section('header-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link rel="Stylesheet" type="text/css" href="/plugins/jquery-ui-datepicker/jquery-ui.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endsection



@section('content')
    <section class="add-section">
        <form id="create_recipe_form" action="{{ route('adminRecipes.create') }}" method="post"
              enctype="multipart/form-data">
            @if(Route::currentRouteName() == 'adminRecipes.create')
                <h3 class="admin-panel-title d-inline-block">Create Recipe</h3>
            @else
                <h3 class="admin-panel-title d-inline-block">Edit Recipe</h3>
            @endif
            <button id="save-draft-btn" type="submit" class="btn btn-draft btn-main pull-right">
                <i class="fa fa-sticky-note" aria-hidden="true"></i> Save Draft
            </button>
            <div class="steps-list" id="steps-list">
                <ol>
                    <li class="@if($step == "step1")current @endif @if(isset($errorCount) && $errorCount[0] >0) has-error @endif">
                        <a href="#">
                            <div class="step-number">1</div>
                            <div class="step-intro">Basic Information</div>
                            <div class="step-error">has {{$errorCount[0]}} error</div>
                        </a>
                    </li>
                    <li class="@if($step == "step2")current @endif @if(isset($errorCount) && $errorCount[1] >0) has-error @endif">
                        <a href="#">
                            <div class="step-number">2</div>
                            <div class="step-intro">Steps</div>
                            <div class="step-error">has {{$errorCount[1]}} error</div>
                        </a>
                    </li>
                    <li class="@if($step == "step3")current @endif @if(isset($errorCount) && $errorCount[2] >0) has-error @endif">
                        <a href="#">
                            <div class="step-number">3</div>
                            <div class="step-intro">Sections</div>
                            <div class="step-error">has {{$errorCount[2]}} error</div>
                        </a>
                    </li>
                    {{--<li class="@if($step == "step4")current @endif">--}}
                        {{--<a href="#">--}}
                            {{--<div class="step-number">4</div>--}}
                            {{--<div class="step-intro">Video</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                </ol>
                <div class="clear-float"></div>
            </div>

            {{ csrf_field() }}
            @if (session('status')=='success')
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if(count($errors))
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger text-left" role="alert"><i class="fa fa-exclamation-circle"
                                                                              aria-hidden="true"></i> {{ $error }}</div>
                @endforeach
            @endif

            @yield('recipe-step')

        </form>

    </section>
@endsection

@section('footer-script')
    <script type="text/javascript">
        $(document).ready(function () {
            var postDraft = "{{ route('adminRecipe.draft') }}";
            $("#save-draft-btn").click(function (e) {
                e.preventDefault();
                $('#create_recipe_form').attr('action', postDraft);
                $('#create_recipe_form').submit();
            });

            $("#steps-list li >a").each(function(index){
                let step = index + 1;
                let url = window.location.href + "/step" + step;

                if ((window.location.pathname).split('/').length >=5){
                    url = window.location.protocol + "//" + window.location.host + (window.location.pathname).slice(0, -1) + step;
                }

                $(this).attr("href", url);
            });
        });
    </script>
    @yield('step-script')

@endsection