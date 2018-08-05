@extends('master')

@section('title', 'Ching He Huang Chinese Cooking | Blog and News | ' . e($blog->title) . ' | ChingHeHuang.com')
@section('page-description',  str_limit(strip_tags($blog->content),100) )
@if($blog->image)
    @section('fb-ref-image', $blog->image->url())
@endif

@section('header-script')

    <script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BlogPosting",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{url()->current()}}"
    },
    "headline": "{{$blog->title}}",
    @if ($blog->image)
            "image": {
                "@type": "ImageObject",
                "url": "{{ $blog->image->url(false,'gblog') }}",
        "width": {{ $blog->image->width < 696 ? '696' : $blog->image->width }},
        "height": {{ $blog->image->width < 696 ? round((696/$blog->image->width)*$blog->image->height,0) : $blog->image->height }}
            },
@endif
        "datePublished": "{{$blog->created_at}}",
    "dateModified": "{{$blog->updated_at}}",
    "author": {
        "@type": "Person",
        "name": "Ching He Huang"
    },
    "publisher": {
        "@type": "Organization",
        "name": "Ching He Huang",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('/images/ching-logo-dark.jpg') }}",
            "width": 252,
            "height": 60
        }
    },
    "description": "Ching He Huang | {{ $blog->title }}"
}















    </script>
@endsection



@section('content')

    <section class="offset-top bg-color white">
        <div class="container-fluid p0">
            @include('front.blog.include.blog-header')
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row standard-padding">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-10 col-12 offset-sm-1 offset-md-0">
                    <div class="blog-detail-section">
                        <h1>{{$blog->title}}</h1>
                        <div class="blog-detail-info"><span class="blog-info-time">{{$blog->created_at}}</span>|<span
                                    class="blog-info-cate">{{$blog->category->name}}</span></div>
                        @if ($blog->image)
                            <img class="img-fluid" src="{{ $blog->image->url() }}"/>
                        @endif

                        <p>{!! $blog->blog_content !!}</p>
                        <div class="social-button-area">
                            <a class="btn btn-border-main" id="collapse-social-media" data-toggle="collapse"
                               data-parent="#accordion" href="#collapseSocialMedia" aria-expanded="false"
                               aria-controls="collapseSocialMedia">
                                <i class="fa fa-share"></i> Share this blog
                            </a>
                            <div id="collapseSocialMedia" class="collapse" role="tabpanel" aria-labelledby="caption">
                                <div class="row no-gutters">
                                    <div class="col">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}"
                                           target="_blank" class="btn btn-block btn-fb text-uppercase social-btn"><i
                                                    class="fa fa-facebook"></i></a>
                                    </div>
                                    <div class="col">
                                        <a href="https://plus.google.com/share?url={{ urlencode(Request::url()) }}"
                                           target="_blank" class="btn btn-block btn-google text-uppercase social-btn"><i
                                                    class="fa fa-google-plus"></i></a>
                                    </div>
                                    <div class="col">
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{rawurlencode("'".$blog->title ."' via @ChingHeHuang")}}"
                                           target="_blank"
                                           class="btn btn-block btn-twitter text-uppercase social-btn"><i
                                                    class="fa fa-twitter"></i></a>
                                    </div>
                                    <div class="col">
                                        <a href="https://pinterest.com/pin/create/button/?{{http_build_query(['url' => Request::url(), 'media' => ($blog->image ? $blog->image->url() : ''), 'description' => $blog->content ])}}"
                                           target="_blank"
                                           class="btn btn-block btn-pinterest text-uppercase social-btn"><i
                                                    class="fa fa-pinterest"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear-float"></div>
                    </div><!-- end of .blog-detail-section -->


                    <div class="mt40 mb40 p0">
                        <div class="title-divider"></div>
                    </div>

                    <!-- blog comment section -->

                    <div class="blog-comment-section">
                        <div class="row mb16">
                            <div class="col-12">
                                <h4>Comments</h4>
                                @if(count($blog_comments)>0)
                                    <p class="small">{{count($blog_comments)}} Comments</p>
                                @endif
                                @if(!Auth::check())
                                    <p class="small">Please login to leave comment.</p>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <ul class="comment-list">
                                    @if(Auth::check())
                                        <li id="new-comment">
                                            <div class="avatar-wrapper">
                                                <div class="comment-avatar-holder">
                                                    @if (isset(Auth::user()->avatar))
                                                        <img class="img-fluid"
                                                             src="{{Storage::url(Auth::user()->avatar)}}">
                                                    @elseif (isset(Auth::user()->facebook_id))
                                                        <img class="img-fluid"
                                                             src="https://graph.facebook.com/{{ Auth::user()->facebook_id }}/picture?width=58&height=58">
                                                    @else
                                                        <img class="img-fluid" src="{{ asset('/images/avatar.png') }}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="content-wrapper">
                                                <div class="comment-content">
                                                    <form action="{{route('comment.create', $blog->id)}}" method="post">
                                                        {{csrf_field()}}
                                                        <textarea rows="2" class="form-control" name="comment"
                                                                  placeholder="Write a comment ..."
                                                                  id="new-comment-text"></textarea>
                                                        <button type="submit" id="submit-comment">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @foreach($blog_comments as $comment)
                                        <li>
                                            <div class="avatar-wrapper">
                                                <div class="comment-avatar-holder @if(isset($comment->user->id) && $comment->user->id==env('CHING_ID'))admin-user @endif ">
                                                    @if (isset($comment->user->avatar))
                                                        <img class="img-fluid"
                                                             src="{{Storage::url($comment->user->avatar)}}">
                                                    @elseif (isset($comment->user->facebook_id))
                                                        <img class="img-fluid"
                                                             src="https://graph.facebook.com/{{ $comment->user->facebook_id }}/picture?width=58&height=58">
                                                    @else
                                                        <img class="img-fluid" src="{{ asset('/images/avatar.png') }}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="content-wrapper">
                                                <div class="comment-content">
                                                    <div class="comment-info">
                                                        <h5 class="comment-username @if(isset($comment->user->id) && $comment->user->id==env('CHING_ID'))admin-user @endif ">@if(isset($comment->user->id)){{$comment->user->first_name}} {{$comment->user->last_name}} @else Unknown @endif</h5>
                                                        <span class="time-stamp">{{$comment->created_at}} {{Auth::id()}}</span>
                                                        <div class="clear-float"></div>
                                                    </div>
                                                    <div class="comment-text">
                                                        <p>{!! nl2br($comment->comment) !!}</p>
                                                    </div>
                                                </div>
                                                @if(Auth::check())
                                                    @if(Auth::user()->admin || Auth::id() == $comment->user->id)
                                                        <div class="comment-control">
                                                            <form action="{{route('comment.delete', $comment->id)}}"
                                                                  method="post">
                                                                {{csrf_field()}}
                                                                <button type="button" class="delete-comment">delete
                                                                </button>
                                                            </form>
                                                            @if(Auth::user()->admin)
                                                                <form id="spam-form"
                                                                      action="{{route('comment.spam', $comment->id)}}"
                                                                      method="post">
                                                                    {{csrf_field()}}
                                                                    <button type="button" class="spam-comment">spam
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div><!-- end of .blog-comment-section -->


                    <div class="mt40 mb40 p0">
                        <div class="title-divider"></div>
                    </div>


                    <div class="related-blog-section">
                        <div class="row mb16">
                            <div class="col-12">
                                <h4>Related blog</h4>
                            </div>
                        </div>
                        <div class="row">

                            <!-- related blog card that contain image -->
                            @foreach($random_related_blogs as $r)

                                <div class="col-xl-4 col-md-6 col-sm-6 col-6">
                                    <div class="card no-border">
                                        <a href="{{route('blog',['cat'=>$r->category->name, 'slug'=>$r->getSlug()])}}">
                                            <div class="related-blog-card wrapBox">
                                                <div class="card-block text-left">
                                                    <h5 class="card-title">{{$r->title}}</h5>
                                                    <p class="card-text">{!! str_limit(strip_tags($r->content),350) !!}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach


                        </div><!-- end of .row -->
                    </div><!-- end of .related-blog-section -->
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-8 col-12 offset-sm-2 offset-md-0">

                    @include('front.widget.twitter-feed')

                    <div class="mt40 mb40 p0">
                        <div class="title-divider"></div>
                    </div>

                    @include('front.widget.side-offer')

                </div>
            </div>
        </div><!-- end of .container -->
    </section>





@endsection





@section('footer-script')
    <script type="text/javascript">

        $(document).ready(function () {
            setWrapBoxHeight();
            $('textarea')
                .autogrow({vertical: true, horizontal: false})
                .on('focus', function () {
                    $('#submit-comment').show();
                    setTimeout(function () {
                        $('#submit-comment').css({
                            top: 0,
                        })
                    }, 150)
                });

            $('.spam-comment').click(function () {
                var r = confirm("Are you sure to remove all comments of this user and delete this user?");
                if (r == true) {
                    $(this).parent().submit();
                }
            });
            $('.delete-comment').click(function () {
                var r = confirm("Are you sure to delete this comment?");
                if (r == true) {
                    $(this).parent().submit();
                }
            });
        });

        window.onresize = function () {
            setTimeout(function () {
                setWrapBoxHeight();
            }, 300);
        };

    </script>
@endsection