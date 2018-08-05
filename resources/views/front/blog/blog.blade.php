@extends('master')

@section('title', 'Ching He Huang Chinese Cooking | Blog and News | ChingHeHuang.com')
@section('page-description', 'Renowned TV chef and cookery writer Ching shares her updates and inspirations from her exciting foodie adventures and experiences in Chinese culinary culture.') {{-- Defaults --}}
{!! \Roumen\Feed\Feed::link(route('blog-rss'), 'atom', 'ChingHeHuang.com', 'en') !!}
@section('fb-ref-image', config('app.url') . '/images/blog/food-blog-banner.jpg')
@section('header-script')

@endsection



@section('content')

    <section class="offset-top bg-color white">
        <div class="container-fluid p0">
            @include('front.blog.include.blog-header')
        </div>
    </section>

    <section class="bg-color white mt24" >
        <div class="container-fluid">
            <div class="row standard-padding">

                <div class="col-12">
                    <div class="blog-categories text-center">

                        @foreach($blog_categories as $blog_category)
                            @if($blog_category->blogs->count())
                            <a href="{{ route('blog', $blog_category->name ) }}">
                                <button class="filter-button @if($cat_id == $blog_category->name)active @endif" role="button" aria-pressed="true">
                                    <span class="cate-total">{{$blog_category->blogs->count()}}</span> {{$blog_category->name}}
                                </button>
                            </a>
                            @endif
                        @endforeach

                            <a href="{{ route('blog-rss') }}">
                                <button class="filter-button rss" role="button" aria-pressed="true">
                                    <i class="fa fa-rss-square" aria-hidden="true"></i> RSS
                                </button>
                            </a>

                    </div>
                </div>
            </div>

            <div class="row standard-padding">
                <div class="col">
                    <div class="grid blog-list" data-masonry='{ "itemSelector": ".grid-item", "columnWidth": 200 }'>
                        @foreach($blogs as $key=> $blog)
                            <div class="grid-item">

                                @if (!$blog->image)
                                    <a href="{{route('blog',['cat'=>$blog->category->name, 'slug'=>$blog->getSlug()])}}">
                                        <div class="card">
                                            <div class="card-block without-image text-left">
                                                <div class="card-title">{{$blog->title}}</div>
                                                <p class="card-text">{!! trim(str_limit(strip_tags($blog->content),350)) !!}</p>
                                                <p class="date-label"><i class="fa fa-calendar" aria-hidden="true"></i> {{ date('Y-m-d', strtotime($blog->created_at)) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{route('blog',['cat'=>$blog->category->name, 'slug'=>$blog->getSlug()])}}">
                                        <div class="card">
                                            <div class="blog-card-image">
                                                <img src="{{$blog->image->url(false,'medium')}}" />
                                            </div>
                                            <div class="card-block text-left">
                                                <div class="card-title">{{$blog->title}}
                                                    <span class="date-label"><i class="fa fa-calendar" aria-hidden="true"></i> {{ date('Y-m-d', strtotime($blog->created_at)) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row standard-padding">
                <div class="col">
                    <!-- pagination bar -->
                    <div class="hidden-sm-down">
                        {{--{{ $blogs->appends(['year'=> $year, 'month'=>$month])->links('vendor.pagination.default') }}--}}
                        {{ $blogs->links('vendor.pagination.default') }}
                    </div>
                    <div class="hidden-md-up">
                        {{--{{ $blogs->appends(['year'=> $year, 'month'=>$month])->links('vendor.pagination.default-mobile') }}--}}
                        {{ $blogs->links('vendor.pagination.default-mobile') }}
                    </div>
                </div>
            </div>


            {{--<div class="row standard-padding">
                <div class="col">
                    <!-- blog content -->
                    <blog></blog>
                    <div class="card-columns blog-list">

                        <!-- card -->
                        @foreach($blogs as $key=> $blog)

                            @if ($blog->image_url == '')
                                <a href="{{route('blog',$blog->getSlug())}}">
                                    <div class="card">
                                        <div class="card-block without-image text-left">
                                            <h1 class="card-title">{{$blog->title}}</h1>
                                            <p class="card-text">{!! trim(str_limit(strip_tags($blog->content),350)) !!}</p>
                                            <p class="date-label"><i class="fa fa-calendar" aria-hidden="true"></i> {{ date('Y-m-d', strtotime($blog->updated_at)) }}</p>
                                        </div>
                                    </div>
                                </a>
                                @else
                                <a href="{{route('blog',$blog->getSlug())}}">
                                        <div class="card">
                                            <div class="blog-card-image">
                                                <img src="{{trim($blog->image_url)}}" />
                                            </div>
                                            <div class="card-block text-left">
                                                <h1 class="card-title">{{$blog->title}}
                                                    <span class="date-label"><i class="fa fa-calendar" aria-hidden="true"></i> {{ date('Y-m-d', strtotime($blog->updated_at)) }}</span>
                                                </h1>
                                            </div>
                                        </div>
                                    </a>
                            @endif

                        @endforeach
                    </div>

                    <div class="hidden-sm-down">
                        {{ $blogs->appends(['year'=> $year, 'month'=>$month])->links('vendor.pagination.default') }}
                    </div>

                    <div class="hidden-md-up">
                        {{ $blogs->appends(['year'=> $year, 'month'=>$month])->links('vendor.pagination.default-mobile') }}

                    </div>


                </div>
            </div>--}}


        </div>
    </section>


@endsection




<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
@section('footer-script')
    {{--<script src="https://unpkg.com/masonry-layout@4.1/dist/masonry.pkgd.min.js"></script>--}}
    {{-- have some problem when complie, wait for @hilton to fix--}}
    <script src="{{ elixir('js/masonry.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.1.8/imagesloaded.pkgd.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {

            $('.select2-box').select2({minimumResultsForSearch: -1});
            $('.select2').css('width', '100%');


                jQueryBridget( 'masonry', Masonry, $ );

                $('.grid').imagesLoaded(function(){
                    $('.grid').masonry({
                        // options...
                        itemSelector: '.grid-item',
                        columnWidth: '.grid-item',
                        percentPosition: true,
                        gutter: 10
                    });
                });


        });

        /*if ($(window).width() < 468) {
            var pageBar = $(".blog-pagination");
            var totalPageBubbles = pageBar.children("li").length;
            var totalDot = pageBar.children(".disabled").length;
            console.log(totalPageBubbles);
            console.log(totalDot);
            if (totalDot == 1 && pageBar.children("li:eq(3)").text() != "...") {
                console.log("true")
            }
        }*/


    </script>
    <script>
        window.Laravel = { csrfToken: '{{ csrf_token() }}' };
    </script>
@endsection