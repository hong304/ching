<div class="row no-gutters standard-padding">
    <div class="col-lg-12 text-center mt40">
        <h2 class="title-text">Instagram Post</h2>
        <p class="text-uppercase mb8">Follow me in Instagram</p>
    </div>
    <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-10 offset-1 mb40">
        <div class="title-divider"></div>
    </div>
</div>


<div class="mb40">
    <div class="owl-carousel owl-theme card-group">
    @foreach( $items as $item)
        <!-- card -->
            <div class="card no-border mb0">
                <a href="{{ $item['link'] }}" target="_blank">
                    <div class="recipe-card">
                        <div class="card-img-top">
                            <div class="card-img-holder">
                                <img class="img-fluid" src="{{ $item['images']['standard_resolution']['url'] }}"
                                     style="position: relative; top: 50%;transform: translateY(-50%);">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

    </div><!-- end of .owl-carousel -->
</div><!-- end of .video-list -->