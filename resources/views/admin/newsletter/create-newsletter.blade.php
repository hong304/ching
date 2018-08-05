@extends('admin')

@section('title', 'Edit Blog')

@section('header-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link rel="Stylesheet" type="text/css" href="/plugins/jquery-ui-datepicker/jquery-ui.min.css">
@endsection



@section('content')
    <section class="add-section">
        <h3 class="admin-panel-title">Create Regular Newsletter</h3>

        <form id="create_edm_form" action="{{route('adminNewsletter.edit')}}" method="post"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            @if (session('status')=='success')
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if(count($errors))
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger text-left" role="alert">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $error }}
                    </div>
                @endforeach
            @endif
            <div class="card-block">
                <label>Newsletter Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="card-block">
                <label>Email Subject</label>
                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
            </div>

            <!-- image section -->
            <div class="card-block">
                <label class="d-block">Cover Image</label>
                <div class="file-wrapper">
                    <div class="file-box">
                        <input type="file" name="cover_image" id="cover_image" class="input-file-btn">
                        <label for="cover_image" class="image-btn">
                            <strong>
                                <span><i class="fa fa-picture-o" aria-hidden="true"></i> Choose a file</span>
                            </strong>
                        </label>
                    </div>
                    <div class="image-preview-wrapper" id="image-preview-wrapper">
                        <label for="cover_image" class="image-btn">
                            <strong>
                                <span><i class="fa fa-picture-o" aria-hidden="true"></i></span>
                            </strong>
                        </label>
                        <div class="image-preview-box">
                            <img class="image-preview" id="image-preview" src="">
                        </div>
                    </div>
                </div>
                <p class="remarks">The image width cannot be less than 580 px. <span id="image-size"></span></p>
                <div class="alert alert-danger text-left" id="image-size-error">
                    <i class="fa fa-exclamation-circle"></i>
                    Please select other image! The Image is too small.
                </div>
            </div>
            <div class="card-block">
                <label>Cover Image Alt text</label>
                <input type="text" name="cover_image_alt" class="form-control" value="{{ old('cover_image_alt') }}">
            </div>
            <!-- end of image section -->

            <!-- markdown section -->
            <div class="card-block">
                <label>Newsletter Content</label>
                <textarea id="editor" name="text_module_content">{{ old('text_module_content') }}</textarea>
            </div>
            <!-- end of markdown section -->
            <div class="card-block row">
                <div class="col-sm-4">
                    <div class="card-block">
                        <label>Scheduled Date</label>
                        <input type="text" class="form-control" name="scheduled_date" placeholder="YYYY-mm-dd"
                               value="{{old('scheduled_date')}}"
                               id="scheduled_date">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card-block">
                        <label>Hour</label>
                        <input type="number" class="form-control" name="scheduled_hour" value="{{old('scheduled_hour')}}" max="23" min="0">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card-block">
                        <label>Minute</label>
                        <input type="number" class="form-control" name="scheduled_minute" value="{{old('scheduled_minute')}}" max="59" min="0">
                    </div>
                </div>
            </div>

            <div class="card-block">
                <button id="submit-btn" type="submit" class="btn btn-block btn-main"><i class="fa fa-floppy-o"></i> Save
                </button>
            </div>
        </form>

    </section>
@endsection

@section('footer-script')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="/plugins/jquery-ui-datepicker/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#scheduled_date").datepicker({dateFormat: "yy-mm-dd"});

            var simplemde = new SimpleMDE({
                element: $("#editor")[0],
                toolbar: ["bold", "italic", "heading", "|", "unordered-list", "ordered-list", "link", "|", "preview", "side-by-side", "fullscreen", "|", "guide"],
            });

            $("#image-size-error").hide();

            $("input[type=file]").on("change", function () {
                $(".image-preview-wrapper").fadeIn('slow');
                readURL(this);

                setTimeout(function () {
                    var naturalWidth = $("#image-preview")[0].naturalWidth;
                    var naturalHeight = $("#image-preview")[0].naturalHeight;
                    $("#image-size").text(" (Current Image dimension: " + naturalWidth + "px (w) x " + naturalHeight + " px (h).)");
                    if (naturalWidth < 580) {
                        $("#image-size-error").show();
                    } else {
                        $("#image-size-error").hide();
                    }
                }, 300);
            });
        });

        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.image-preview').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection