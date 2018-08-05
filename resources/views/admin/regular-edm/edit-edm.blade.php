@extends('admin')

@section('title', 'Edit Blog')

@section('header-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <link rel="Stylesheet" type="text/css" href="/plugins/jquery-ui-datepicker/jquery-ui.min.css">
@endsection



@section('content')
    <section class="add-section">
        <h3 class="admin-panel-title">Edit Regular EDM</h3>

        <form id="create_edm_form" action="{{route('adminEdm.edit')}}" method="post" enctype="multipart/form-data">
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
            <input type="hidden" name="id" value="{{$edm->id}}">
            <div class="card-block">
                <label>EDM Name</label>
                <input type="text" name="name" class="form-control" value="{{old('name', $edm->name)}}">
            </div>
            <div class="card-block">
                <label>EDM Section Chosen: </label>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input edm_section" type="checkbox" name="edm_section[0]" value="header"
                               @if(old('edm_section.0')) checked
                               @elseif(!old('edm_section') && $edm->header_content) checked @endif> Header
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input edm_section" type="checkbox" name="edm_section[1]" value="blog"
                               @if(old('edm_section.1')) checked
                               @elseif(!old('edm_section') && $edm->blog_title) checked @endif> Blog
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input edm_section" type="checkbox" name="edm_section[2]"
                               value="instagram" @if(old('edm_section.2')) checked
                               @elseif(!old('edm_section') && $edm->instagram_link_1) checked @endif> Instagram
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input edm_section" type="checkbox" name="edm_section[3]" value="recipe"
                               @if(old('edm_section.3')) checked
                               @elseif(!old('edm_section') && $edm->recipe_title) checked @endif> Recipe
                    </label>
                </div>
            </div>
            <div class="card-block">
                <label>Email Subject</label>
                <input type="text" name="subject" class="form-control" value="{{old('subject', $edm->subject)}}">
            </div>
            <fieldset id="header">
                <legend>Header</legend>
                <div class="card-block">
                    <label>Header Title</label>
                    <input type="text" name="header_title" class="form-control" value="{{old('header_title', $edm->header_title)}}">
                </div>
                <div class="card-block">
                    <label>Header Content</label>
                    <textarea class="form-control"
                              name="header_content">{{old('header_content', $edm->header_content)}}</textarea>
                </div>
            </fieldset>
            <fieldset id="blog">
                <legend>Blog</legend>
                <div class="card-block">
                    <label>Blog Title</label>
                    <input type="text" name="blog_title" class="form-control"
                           value="{{old('blog_title', $edm->blog_title)}}">
                </div>
                <div class="card-block row">
                    <div class="col-sm-4">
                        <div class="image-preview-holder @if(!$edm->blog_image_id) no-image @endif mt-4" id="blog_image-preview-holder">
                            <div class="image-preview-crop">
                                <img class="image-preview" id="blog_image-preview" src="@if($edm->blog_image_id){{$edm->blogImage->url()}}@endif">
                            </div>
                        </div>
                        <div class="file-box pull-right mt-4">
                            <input type="file" name="blog_image" id="blog_image" class="input-file-btn" files
                                   onchange="changeImageSelected(this)"/>
                            <label for="blog_image" class="image-btn">
                                <strong>
                                    <span><i class="fa fa-picture-o" aria-hidden="true"></i> Choose a file</span>
                                </strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card-block">
                            <label>Alt Text</label>
                            <input type="text" name="blog_image_alt" class="form-control"
                                   value="{{old('blog_image_alt', $edm->blog_image_alt)}}">
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <label>Blog Link</label>
                    <input type="text" name="blog_link" class="form-control"
                           value="{{old('blog_link', $edm->blog_link)}}">
                </div>
                <div class="card-block">
                    <label>Date of Blog</label>
                    <input type="text" class="form-control" name="blog_date" placeholder="YYYY-mm-dd"
                           value="{{old('blog_date', $edm->blog_date)}}"
                           id="blog_date">
                </div>
                <div class="card-block">
                    <label>Blog Content</label>
                    <textarea class="form-control" name="blog_intro">{{old('blog_intro', $edm->blog_intro)}}</textarea>
                </div>
            </fieldset>
            <fieldset id="instagram">
                <legend>Instagram</legend>
                <div class="card-block row">
                    <label class="col-sm-12">Instagram Photo 1</label>
                    <div class="col-sm-4">
                        <div class="image-preview-holder @if(!$edm->instagram_image_id_1)no-image @endif mt-4" id="instagram_image_1-preview-holder">
                            <div class="image-preview-crop">
                                <img class="image-preview" id="instagram_image_1-preview" src="@if($edm->instagram_image_id_1){{$edm->instagramImage1->url()}}@endif">
                            </div>
                        </div>
                        <div class="file-box pull-right mt-4">
                            <input type="file" name="instagram_image_1" id="instagram_image_1" class="input-file-btn"
                                   files onchange="changeImageSelected(this)"/>
                            <label for="instagram_image_1" class="image-btn">
                                <strong>
                                    <span><i class="fa fa-picture-o" aria-hidden="true"></i> Choose a file</span>
                                </strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card-block">
                            <label>Link</label>
                            <input type="text" name="instagram_link_1" class="form-control"
                                   value="{{old('instagram_link_1', $edm->instagram_link_1)}}">
                        </div>
                        <div class="card-block">
                            <label>Alt Text</label>
                            <input type="text" name="instagram_image_alt_1" class="form-control"
                                   value="{{old('instagram_image_alt_1', $edm->instagram_image_alt_1)}}">
                        </div>
                    </div>
                </div>
                <div class="card-block row">
                    <label class="col-sm-12">Instagram Photo 2</label>
                    <div class="col-sm-4">
                        <div class="image-preview-holder @if(!$edm->instagram_image_id_2)no-image @endif mt-4" id="instagram_image_2-preview-holder">
                            <div class="image-preview-crop">
                                <img class="image-preview" id="instagram_image_2-preview" src="@if($edm->instagram_image_id_2){{$edm->instagramImage2->url()}}@endif">
                            </div>
                        </div>
                        <div class="file-box pull-right mt-4">
                            <input type="file" name="instagram_image_2" id="instagram_image_2" class="input-file-btn"
                                   files onchange="changeImageSelected(this)"/>
                            <label for="instagram_image_2" class="image-btn">
                                <strong>
                                    <span><i class="fa fa-picture-o" aria-hidden="true"></i> Choose a file</span>
                                </strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card-block">
                            <label>Link</label>
                            <input type="text" name="instagram_link_2" class="form-control"
                                   value="{{old('instagram_link_2', $edm->instagram_link_2)}}">
                        </div>
                        <div class="card-block">
                            <label>Alt Text</label>
                            <input type="text" name="instagram_image_alt_2" class="form-control"
                                   value="{{old('instagram_image_alt_2', $edm->instagram_image_alt_2)}}">
                        </div>
                    </div>
                </div>
                <div class="card-block row">
                    <label class="col-sm-12">Instagram Photo 3</label>
                    <div class="col-sm-4">
                        <div class="image-preview-holder @if(!$edm->instagram_image_id_3)no-image @endif mt-4" id="instagram_image_3-preview-holder">
                            <div class="image-preview-crop">
                                <img class="image-preview" id="instagram_image_3-preview" src="@if($edm->instagram_image_id_3){{$edm->instagramImage3->url()}}@endif">
                            </div>
                        </div>
                        <div class="file-box pull-right mt-4">
                            <input type="file" name="instagram_image_3" id="instagram_image_3" class="input-file-btn"
                                   files onchange="changeImageSelected(this)"/>
                            <label for="instagram_image_3" class="image-btn">
                                <strong>
                                    <span><i class="fa fa-picture-o" aria-hidden="true"></i> Choose a file</span>
                                </strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card-block">
                            <label>Link</label>
                            <input type="text" name="instagram_link_3" class="form-control"
                                   value="{{old('instagram_link_3', $edm->instagram_link_3)}}">
                        </div>
                        <div class="card-block">
                            <label>Alt Text</label>
                            <input type="text" name="instagram_image_alt_3" class="form-control"
                                   value="{{old('instagram_image_alt_3', $edm->instagram_image_alt_3)}}">
                        </div>
                    </div>
                </div>
                <div class="card-block row">
                    <label class="col-sm-12">Instagram Photo 4</label>
                    <div class="col-sm-4">
                        <div class="image-preview-holder @if(!$edm->instagram_image_id_4)no-image @endif mt-4" id="instagram_image_4-preview-holder">
                            <div class="image-preview-crop">
                                <img class="image-preview" id="instagram_image_4-preview" src="@if($edm->instagram_image_id_4){{$edm->instagramImage4->url()}}@endif">
                            </div>
                        </div>
                        <div class="file-box pull-right mt-4">
                            <input type="file" name="instagram_image_4" id="instagram_image_4" class="input-file-btn"
                                   files onchange="changeImageSelected(this)"/>
                            <label for="instagram_image_4" class="image-btn">
                                <strong>
                                    <span><i class="fa fa-picture-o" aria-hidden="true"></i> Choose a file</span>
                                </strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card-block">
                            <label>Link</label>
                            <input type="text" name="instagram_link_4" class="form-control"
                                   value="{{old('instagram_link_4', $edm->instagram_link_4)}}">
                        </div>
                        <div class="card-block">
                            <label>Alt Text</label>
                            <input type="text" name="instagram_image_alt_4" class="form-control"
                                   value="{{old('instagram_image_alt_4', $edm->instagram_image_alt_4)}}">
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset id="recipe">
                <legend>Recipe</legend>
                <div class="card-block">
                    <label>Recipe Title</label>
                    <input type="text" name="recipe_title" class="form-control" value="{{old('recipe_title', $edm->recipe_title)}}">
                </div>
                <div class="card-block row">
                    <label class="col-sm-12">Instagram Photo 4</label>
                    <div class="col-sm-4">
                        <div class="image-preview-holder @if(!$edm->recipe_image_id)no-image @endif mt-4" id="recipe_image-preview-holder">
                            <div class="image-preview-crop">
                                <img class="image-preview" id="recipe_image-preview" src="@if($edm->recipe_image_id){{$edm->recipeImage->url()}}@endif">
                            </div>
                        </div>
                        <div class="file-box pull-right mt-4">
                            <input type="file" name="recipe_image" id="recipe_image" class="input-file-btn" files
                                   onchange="changeImageSelected(this)"/>
                            <label for="recipe_image" class="image-btn">
                                <strong>
                                    <span><i class="fa fa-picture-o" aria-hidden="true"></i> Choose a file</span>
                                </strong>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card-block">
                            <label>Alt Text</label>
                            <input type="text" name="recipe_image_alt" class="form-control"
                                   value="{{old('recipe_image_alt', $edm->recipe_image_alt)}}">
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <label>Recipe Link</label>
                    <input type="text" name="recipe_link" class="form-control" value="{{old('recipe_link', $edm->recipe_link)}}">
                </div>
                <div class="card-block">
                    <label>Recipe Content</label>
                    <textarea class="form-control" name="recipe_intro">{{old('recipe_intro', $edm->recipe_intro)}}</textarea>
                </div>
            </fieldset>
            <div class="card-block">
                <button id="submit-btn" type="submit" class="btn btn-block btn-main"><i class="fa fa-floppy-o"></i> Save
                </button>
            </div>
        </form>

    </section>
@endsection

@section('footer-script')
    <script src="/plugins/jquery-ui-datepicker/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            $("#blog_date").datepicker({dateFormat: "yy-mm-dd"});
            $('.select2-box').select2();

            sectionControl();

            $(".edm_section").change(function () {
                sectionControl();
            });
        });
        function changeImageSelected(el) {
            var previewHolder = $("#" + $(el).attr("id") + "-preview-holder");
            var previewDiv = $("#" + $(el).attr("id") + "-preview");

            previewHolder.removeClass('no-image');

            if (el.files && el.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    previewDiv.attr('src', e.target.result);
                };

                reader.readAsDataURL(el.files[0]);
            }
        }

        function sectionControl() {
            $(".edm_section").each(function () {
                if ($(this).prop("checked") == true) {
                    $("#" + $(this).val()).show();
                } else {
                    $("#" + $(this).val()).hide();
                }
            });
        }
    </script>
@endsection