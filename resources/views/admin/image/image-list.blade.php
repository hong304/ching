@extends('admin')

@section('title', 'Edit Blog')

@section('header-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endsection



@section('content')
    <section>
        <h3 class="admin-panel-title">Image List</h3>
        @if (session('status')=='success')
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <ul class="nav nav-tabs" role="tablist">
            @foreach($imageCategories as $imageCategory)
                <li class="nav-item">
                    <a class="nav-link @if($imageCategory == $currentCategory)active @endif"
                       href="{{route('adminImage.index', $imageCategory)}}"
                       role="tab">{{ucfirst($imageCategory)}}</a>
                </li>
            @endforeach
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">

            @if($currentCategory != "upload")
                <div class="tab-pane image-tab active" id="{{$currentCategory}}" role="tabpanel">
                    <div class="card-deck">
                        @foreach($imagesArr as $image)
                            <a href="javascript:void(0);" class="image-link-modal pl-2">
                                <div class="card mb-2 mt-2 image-card">
                                    <img class="card-img-top" src="{{ $image->url(false, "small") }}">
                                    <input type="hidden" class="big-img-src" value="{{$image->url(false, "original")}}">
                                    <input type="hidden" class="image-id" value="{{$image->id}}">
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="row standard-padding">
                    <div class="col">
                        <!-- pagination bar -->
                        <div class="hidden-sm-down">
                            {{ $imagesArr->links('vendor.pagination.default') }}
                        </div>
                        <div class="hidden-md-up">
                            {{ $imagesArr->links('vendor.pagination.default-mobile') }}
                        </div>
                    </div>
                </div>
            @else
                @if(count($errors))
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger text-left" role="alert">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $error }}
                        </div>
                    @endforeach
                @endif
                <div class="tab-pane active" id="upload" role="tabpanel">
                    <form method="post" action="{{route('adminImage.upload')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-block">
                            <label>Please choose an image:</label>
                            <div class="file-box">
                                <input type="file" name="upload_image" id="upload_image" class="input-file-btn" files/>
                                <label for="upload_image"><strong><i class="fa fa-picture-o" aria-hidden="true"></i>
                                        Choose a file</strong><span id="file_name" class="pl-2"></span></label>
                            </div>
                            <img class="image-preview" id="image-preview" src="">
                        </div>
                        <div class="card-block">
                            <button type="submit" class="btn btn-default">Upload</button>
                        </div>
                    </form>
                </div>
            @endif

        </div>

        <div class="modal fade" id="deleteImage" tabindex="-1" role="dialog" aria-labelledby="deleteImageLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteImageLabel">Are you sure to delete this image?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('adminImage.delete')}}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <input type="hidden" name="image_id" id="deleteImageId">
                            <img id="deleteModalImage" src="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer-script')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            $(".image-link-modal").click(function () {
                $("#deleteModalImage").attr("src", $(this).find('.big-img-src').val());
                $("#deleteImageId").val($(this).find('.image-id').val());
                $('#deleteImage').modal('show');
            });

            $("#upload_image").change(function (e) {
                $("#file_name").text(e.target.files[0].name);
                readURL(this);
            });

            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#image-preview').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        });
    </script>
@endsection