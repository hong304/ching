@extends('admin')

@section('title', 'Edit Blog')

@section('header-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <link rel="Stylesheet" type="text/css" href="/plugins/jquery-ui-datepicker/jquery-ui.min.css">
@endsection



@section('content')
    <section class="add-section">
        <h3 class="admin-panel-title">Create Blog</h3>

        <form id="create_blog_form" action="{{route('adminBlog.create')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            @if (session('status')=='success')
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if(count($errors))
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger text-left" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $error }}</div>
                @endforeach
            @endif
            <div class="card-block">
                <label>Blog Title</label>
                <input id="blog_title" type="text" name="blog_title" class="form-control" value="{{old('blog_title')}}">
            </div>
            <div class="card-block">
                <label>Slug</label>
                <input id="slug" type="text" name="slug" class="form-control" value="{{old('slug')}}">
            </div>
            <div class="card-block">
                <label>Blog Category</label>
                <select class="form-control select2-box" id="blog_category" name="blog_category">
                    @foreach($blogCategories as $blogCategory)
                        <option value="{{$blogCategory->id}}" {{ (old('blog_category') == $blogCategory->id ? "selected": "") }}>{{$blogCategory->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="card-block">
                <label class="pull-left">Blog Image</label>
                <ul class="nav nav-tabs pull-left" id="imageSelectionTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#uploadImage" role="tab"
                           aria-controls="uploadImage"><i class="fa fa-upload" aria-hidden="true"></i> Upload new image</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#selectFromGallery" role="tab"
                           aria-controls="selectFromGallery"><i class="fa fa-folder-open" aria-hidden="true"></i> Select from gallery</a>
                    </li>
                </ul>
                <div class="tab-content clear-float">

                    <div class="image-preview-holder no-image">
                        <div class="image-preview-crop">
                            <img class="image-preview" id="image-preview" src="">
                        </div>
                    </div>

                    <div class="tab-pane active" id="uploadImage" role="tabpanel">
                        <div class="card-block">
                            <div class="file-box">
                                <input type="file" name="blog_image" id="blog_image" class="input-file-btn" files onchange="changeImageSelected(this)"/>
                                <label for="blog_image">
                                    <strong>
                                        <span><i class="fa fa-picture-o" aria-hidden="true"></i> Choose a file</span>
                                    </strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="selectFromGallery" role="tabpanel">
                        <input type="hidden" name="blog_image_id" id="blog_image_id" value="{{old('blog_image_id')}}">
                        <div class="card-block">
                            <ul class="nav nav-tabs" role="tablist" id="imageCategoryTab">
                                @foreach($imageCategories as $key=>$imageCategory)
                                <li class="nav-item">
                                    <a class="nav-link @if($key == 0) active @endif" data-toggle="tab" href="#{{$imageCategory}}" role="tab">{{ucfirst($imageCategory)}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="tab-content">
                            @foreach($imageCategories as $key=>$imageCategory)
                            <div class="tab-pane image-tab @if($key == 0) active @endif" id="{{$imageCategory}}" role="tabpanel">
                                <div class="card-deck">
                                </div>
                                <button class="btn btn-main" disabled type="button" onclick="ajaxLoadImage(this, '{{$imageCategory}}', '2')">More ...</button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <input type="hidden" name="blog_content" id="blog_content" value="{{old('blog_content')}}">
                <label>Blog Content</label>
                <textarea id="editor">{{old('blog_content')}}</textarea>
            </div>
            <div class="card-block">
                <label>Tags</label>
                <select class="form-control select2-box" id="blog_tags" multiple="multiple" name="blog_tags[]">
                    @foreach($blogTags as $blogTag)
                        <option value="{{$blogTag->id}}" {{ (in_array($blogTag->id, old('blog_tags', [])) ? "selected": "") }}>{{ucwords($blogTag->name)}}</option>
                    @endforeach
                    @foreach(old('blog_tags', []) as $blogTag)
                        @if(!is_numeric($blogTag))
                            <option value="{{$blogTag}}" selected>{{ucwords($blogTag)}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
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
                <label>Publish</label>
                <select class="form-control select2-box" id="published" name="published">
                    <option value="1" {{ (old('published') == "1" ? "selected": "") }}>Publish</option>
                    <option value="0" {{ (old('published',"0") == "0" ? "selected": "") }}>Not Publish</option>
                </select>
            </div>
            <div class="card-block">
                <button id="submit-btn" type="submit" class="btn btn-block btn-main">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Create
                </button>
            </div>
        </form>

    </section>
@endsection

@section('footer-script')
    <script src="{{ asset('plugins/imageGallery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="/plugins/jquery-ui-datepicker/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#scheduled_date").datepicker({dateFormat: "yy-mm-dd"});
            var simplemde = new SimpleMDE({
                element: $("#editor")[0],
                toolbar: ["bold", "italic", "heading", "|", "unordered-list", "ordered-list", "link", "|", "preview", "side-by-side", "fullscreen", "|", "guide"],
            });

            $("#submit-btn").click(function (e) {
                e.preventDefault();
                $("#blog_content").val(simplemde.value());
                $("#create_blog_form").submit();
            });

            $('.select2-box').select2({minimumResultsForSearch: -1});
            $('#blog_tags').select2({
                tags: true
            });

            $('.select2').css('width', '100%');

            var api = "{{route('image-data-api')}}";
            initImageGallery($("#blog_image"), $("#blog_image_id"), api);

            $("#blog_title").focusout(function () {
                var slug = $.trim($(this).val());
                slug = slug.toLowerCase();
                if (slug.length > 0 && $.trim($("#slug").val()).length === 0){
                    $("#slug").val(slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-'));
                }
            });

        });


    </script>
@endsection