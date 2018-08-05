<div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">

    <!-- Wrapper for slides -->
    <div class="carousel-inner big-slider-img" @if(rand(0,1)) id="style-b" data-toggle="B" @else data-toggle="A" @endif>

        <div class="carousel-item active">
            <div class="slider-holder">
                <div class="image-placeholder" style="background-image: url('{{asset ('/images/carousel/new-series-flavology.jpg')}}');"></div>
                <div class="caption-holder">
                    <div class="caption-box">
                        <h3 class="title-text"><span class="new-label">NEW</span> Flavology Series</h3>
                        <p class="entry-text">Join Ching as she eats through Hong Kong and whips up her version of quintessential Hong Kong-inspired recipes.</p>
                        <a data-toggle="3" href="{{ route('video-series', 'flavology') }}" class="action-button text-uppercase ga-button">Watch Now</a>
                    </div>
                </div>
            </div>
        </div><!-- End Item -->

        <div class="carousel-item">
            <div class="slider-holder">
                <div class="image-placeholder" style="background-image: url('{{asset ('/images/carousel/mussels-with-chinese-beer.jpg')}}');"></div>
                <div class="caption-holder">
                    <div class="caption-box">
                        <h3 class="title-text">Mussels With Chinese Beer!</h3>
                        <p class="entry-text">Fight the cold of this year's postponed Spring season with this hearty warm recipe.</p>
                        <a data-toggle="1" href="{{ route('recipe', 'mussels-with-chinese-beer') }}" class="action-button text-uppercase ga-button">Wok On!</a>
                    </div>
                </div>
            </div>
        </div><!-- End Item -->

        <div class="carousel-item">
            <div class="slider-holder">
                <div class="image-placeholder" style="background-image: url('{{asset ('/images/carousel/stir-crazy.jpg')}}');"></div>
                <div class="caption-holder">
                    <div class="caption-box">
                        <h3 class="title-text">Let's Get Stir Crazy!</h3>
                        <p class="entry-text">Stir Crazy is a collection of delicious dishes, simple enough for everyday and with nutrition, taste and affordability in mind.</p>
                        <a data-toggle="2" href="{{ route('books') }}" class="action-button text-uppercase ga-button">Purchase now</a>
                    </div>
                </div>
            </div>
        </div><!-- End Item -->

        <div class="carousel-item">
            <div class="slider-holder">
                <div class="image-placeholder" style="background-image: url('{{asset ('/images/herobanner/recipe-170220-02.jpg')}}');"></div>
                <div class="caption-holder">
                    <div class="caption-box">
                        <h3 class="title-text">Be Inspired!</h3>
                        <p class="entry-text">Search through Ching's collection of signature recipes, which use fresh and healthy ingredients in a fusion of Eastern and Western cuisine.</p>
                        <a data-toggle="4" href="{{ route('recipe') }}" class="action-button text-uppercase ga-button">Discover More</a>
                    </div>
                </div>
            </div>
        </div><!-- End Item -->

    </div><!-- End Carousel Inner -->


    <ul class="nav nav-pills nav-justified hidden-sm-down">
        <li data-target="#myCarousel" data-slide-to="0" class="col hero-carousel-nav slider-title-button active">
            <h2>Food & Travel</h2>
        </li>
        <li data-target="#myCarousel" data-slide-to="1" class="col hero-carousel-nav slider-title-button">
            <h2>Recipe of the month</h2>
        </li>
        <li data-target="#myCarousel" data-slide-to="2" class="col hero-carousel-nav slider-title-button">
            <h2>Latest book</h2>
        </li>
        <li data-target="#myCarousel" data-slide-to="3" class="col hero-carousel-nav slider-title-button">
            <h2>Meal ideas</h2>
        </li>
    </ul>


</div><!-- End Carousel -->