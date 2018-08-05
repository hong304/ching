@extends('admin.recipe.recipe-form')
@section('recipe-step')
<!-- recipe step -->
<input name="step" type="hidden" value="1">
<!-- recipe name section -->
<div class="card-block" id="video-select-list">
    <label>Video</label>
    @foreach($videoList as $video)
        <div class="card-block">
            <div class="image-holder">
                <img src="{{ $video->image ? $video->image->url(false,'medium') : asset('/images/video.jpg') }}" alt="{{ $video->name }}" />
            </div>
            <div class="intro-holder">
                <h5>Video Title : {{ $video->name }}</h5>
                <p>
                    Duration :
                    @if($video->duration_seconds >=3600)
                        {{ gmdate('H:i:s', $video->duration_seconds) }}
                    @else
                        {{ gmdate('i:s', $video->duration_seconds) }}
                    @endif
                </p>
                <p>Intro : {{ $video->description }}</p>
                <button class="btn btn-main">Use this video</button>
            </div>
        </div>
    @endforeach
</div>




<div class="card-block">
    <button id="submit-btn" type="submit" class="btn btn-next btn-grey pull-left">
        <i class="fa fa-angle-left" aria-hidden="true"></i> Previous
    </button>
    <button id="submit-btn" type="submit" class="btn btn-next btn-main pull-right">
        <i class="fa fa-angle-right" aria-hidden="true"></i> Next
    </button>
    <button id="submit-btn" type="submit" class="btn btn-next btn-medium-grey pull-right mr-8">
        <i class="fa fa-angle-double-right" aria-hidden="true"></i> Skip
    </button>
</div>
@endsection


@section('step-script')

@endsection