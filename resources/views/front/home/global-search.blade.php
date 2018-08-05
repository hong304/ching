@extends('master')
@section('title', 'Ching He Huang Chinese Cooking | Search result | ChingHeHuang.com')
@section('header-script')

@endsection



@section('content')

    <section class="offset-top bg-color white">
        <div class="container pt40 mb40">
            <div class="row m0">
                <div class="col-md-8 col-12 offset-md-2">
                    <div class="text-md-left text-center">
                        <div class="static-page-content">
                            <h1 class="static-content-title text-uppercase">Search result : </h1>

                            @foreach($result as $v)
                                <a href="#"><h5>{!! $v->getSearchTitle(explode(" ",$keyword)) !!}</h5></a>
                                <p>{!! $v->getSearchContent(explode(" ",$keyword)) !!}</p>
                                <hr class="mt24 mb24">
                            @endforeach

                        </div><!-- end of .static-page-content -->
                    </div>
                </div>

            </div><!-- end of .row -->
        </div>
    </section>


@endsection




@section('footer-script')

@endsection